<?php

namespace Directus\Custom\Hooks\Feedback;

use Directus\Hook\HookInterface;
use Directus\Hook\Payload;
use Directus\Mail\Message;
use Directus\Application\Application;
use Directus\Services\UsersService;
use Directus\Permissions\Acl;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use function Directus\send_mail_with_template;

class AfterCreateFeedback implements HookInterface
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
        $container->get('acl')->setPermissions([
            'directus_users' => [
                [
                    Acl::ACTION_READ   => Acl::LEVEL_FULL,
                ],
            ],
        ]);
        $logger->info('AfterCreateFeedback', ['payload' => $payload]);

        // retrieve admin email
        $userService = new UsersService($container);
        $admin = $userService->find(1)['data'];

        try {
            $phoneUtil = PhoneNumberUtil::getInstance();
            $numberProto = $phoneUtil->parse($payload['phone'], 'IL');
            $payload['phone'] = $phoneUtil->format($numberProto, PhoneNumberFormat::NATIONAL);
        } catch (NumberParseException $e) {

        }

        // format phone
        try {
            $from = [];
            $from[$payload['email']] = $payload['first_name'] . ' ' . $payload['last_name'];
            $toAddresses = [$admin['email']];
            $subject = 'New feedback';

            send_mail_with_template(
                'new-feedback.twig',
                $payload,
                function (Message $message) use ($from, $toAddresses, $subject) {
                    $message->setFrom($from);
                    $message->setTo($toAddresses);
                    $message->setSubject($subject);
                }
            );
        } catch (Swift_RfcComplianceException $ex) {

        }
    }
}
