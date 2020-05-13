<?php

namespace Directus\Custom\Hooks\Auth;

use Directus\Hook\HookInterface;
use Directus\Hook\Payload;
use Directus\Mail\Message;
use Directus\Application\Application;
use Directus\Services\UsersService;
use Directus\Services\ActivityService;
use Directus\Services\RevisionsService;
use Directus\Authentication\User\User;
use Directus\Permissions\Acl;
use Directus\Util\StringUtils;
use function Directus\send_mail_with_template;
use DateTime;
use DateInterval;

class AuthRequestCredentials implements HookInterface
{
    /**
     * @param User $user
     */
    public function handle($user = null)
    {
        // Enforce users to change their password once every quarter.
        $app = Application::getInstance();
        $container = $app->getContainer();
        $logger = $container->get('logger');
        $logger->info('User Logins', [
            'userId' => $user->getId(),
        ]);
        $securityPasswordPeriod = $app->getConfig()['app_settings']['security_password_period'];

        if (1 === (int) $user->getId()) {
            // admin no need to reset password
            $logger->info('Is Admin');
            return;
        } elseif ($user->getEmail() === 'demo@example.com') {
            // demo user no need to reset password
            $logger->info('Is demo user');
            return;
        }

        $container->get('acl')->setPermissions([
            'directus_activity' => [
                [Acl::ACTION_READ   => Acl::LEVEL_FULL],
            ],
            'directus_revisions' => [
                [Acl::ACTION_READ   => Acl::LEVEL_FULL],
            ],
            'directus_users' => [
                [Acl::ACTION_UPDATE => Acl::LEVEL_MINE],
            ],
        ])->setUserId($user->getId());

        // retrieve activity
        $lastQuarter = new DateTime();
        $lastQuarter->sub(new DateInterval($securityPasswordPeriod));
        $activityService = new ActivityService($container);
        $selectFilters = [
            'action' => 'authenticate',
            'collection' => 'directus_users',
            'item' => $user->getId(),
            'action_on' => ['lt' => $lastQuarter->format('Y-m-d H:i:s')],
        ];
        $oldActivities = $activityService->findAll([
            'filter' => $selectFilters,
            'limit' => 1,
        ]);

        if (!count($oldActivities['data'])) {
            // account created in current quarter
            $logger->info('Account created in current quarter', [
                'quarter' => $lastQuarter->format('Y-m-d H:i:s'),
            ]);
            return;
        }

        // search for current activities
        $selectFilters = [
            'action' => 'update',
            'collection' => 'directus_users',
            'item' => $user->getId(),
            'action_on' => ['gte' => $lastQuarter->format('Y-m-d H:i:s')],
        ];
        $currentActivities = $activityService->findAll([
            'filter' => $selectFilters,
        ]);

        if (count($currentActivities['data'])) {
            // account has been updated in last 3 month
            $logger->info('Activities', [
                'activites' => $currentActivities,
                'select filters' => $selectFilters,
            ]);

            // retrieve revisions
            $activityIds = array_map(function($item) {
                return $item['id'];
            }, $currentActivities['data']);

            $revisionService = new RevisionsService($container);
            $revisions = $revisionService->findAll([
                'filter' => [
                    'activity' => ['in' => $activityIds],
                    'collection' => 'directus_users',
                    'delta' => '[]',
                ],
                'limit' => 1,
            ]);
            $logger->info('Revisions', [
                'revisions' => $revisions,
            ]);

            if (count($revisions['data'])) {
                // account password has been set in current quarter
                $logger->info('Account password has been set in current quarter');
                return;
            }
        }

        $logger->info('Account password is older than 3 months',[
            'quarter' => $lastQuarter->format('Y-m-d H:i:s'),
        ]);

        // forcefully reset password
        $randomPassword = StringUtils::randomString(16);
        $userService = new UsersService($container);
        $userService->update($user->getId(), [
            'password' => $randomPassword,
        ]);

        // send new password via email
        try {
            $email = $user->getEmail();
            $subject = 'New password';
            $template = (intval($user->getId()) === 1) ? 'admin-quarter-password-reset.twig' : 'quarter-password-reset.twig';

            send_mail_with_template(
                $template,
                [
                    'user_full_name' => $user->get('first_name') . ' ' . $user->get('last_name'),
                    'new_password' => $randomPassword,
                ],
                function (Message $message) use ($email, $subject) {
                    $message->setTo($email);
                    $message->setSubject($subject);
                }
            );
        } catch (Swift_RfcComplianceException $ex) {
            $logger->error('Swift RFCCompliance Exception', ['exception' => $ex]);
        } catch (Swift_TransportException $ex) {
            $logger->error('Swift Transport Exception', ['exception' => $ex]);
        }
    }
}
