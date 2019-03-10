<?php

namespace Directus\Custom\Hooks\Profiles;

use Directus\Application\Application;
use Directus\Hook\HookInterface;
use Directus\Hook\Payload;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use Directus\Mail\Message;
use Directus\Services\ItemsService;
use Directus\Services\UsersService;
use function Directus\send_mail_with_template;

class AfterUpdateProfiles implements HookInterface
{
    /**
     * @param Payload $payload
     *
     * @return Payload
     */
    public function handle($payload = null)
    {
        $app = Application::getInstance();
        $container = $app->getContainer();
        $logger = $container->get('logger');
        $auth = $container->get('auth');
        $acl = $container->get('acl');
        $logger->info('AfterUpdateProfiles', ['payload' => $payload, 'acl' => $acl]);

        // retrieve profile item and user owner
        $itemsService = new ItemsService($container);
        $userService = new UsersService($container);
        $profile = $itemsService->find('profiles', $payload['id'])['data'];
        $user = $userService->find($profile['customer'])['data'];
        $logger->info('Profile and user found', ['profile' => $profile, 'user' => $user]);

        $fullname = $user['last_name'];
        $phone1 = null;
        $phone2 = null;
        $homeAddress = null;
        $updatedFields = array_keys($payload);

        if (!empty($profile['phone_1'])) {
            $phoneUtil = PhoneNumberUtil::getInstance();
            $numberProto = $phoneUtil->parse($profile['phone_1'], 'IL');
            $phone1 = $phoneUtil->format($numberProto, PhoneNumberFormat::NATIONAL);
        }

        if (!empty($profile['phone_2'])) {
            $phoneUtil = PhoneNumberUtil::getInstance();
            $numberProto = $phoneUtil->parse($profile['phone_2'], 'IL');
            $phone2 = $phoneUtil->format($numberProto, PhoneNumberFormat::NATIONAL);
        }

        if (!empty($profile['home_address'])) {
            $homeAddress = $profile['home_address'];
        }

        $basePath = $container['path_base'];
        try {
            $from = [
                $acl->getUserEmail() => $acl->getUserFullName(),
            ];
            $toAddresses = [$acl->getUserEmail()];
            $subject = 'Profile has been changed by user';

            send_mail_with_template(
                'profile-updated.twig',
                [
                    'fullname' => $fullname,
                    'phone1' => $phone1,
                    'phone2' => $phone2,
                    'homeAddress' => $homeAddress,
                    'updatedFields' => $updatedFields,
                ],
                function (Message $message) use ($from, $toAddresses, $subject) {
                    $message->setFrom($from);
                    $message->setTo($toAddresses);
                    $message->setSubject($subject);
                }
            );
        } catch (Swift_RfcComplianceException $ex) {

        }
        return $payload;
    }
}
