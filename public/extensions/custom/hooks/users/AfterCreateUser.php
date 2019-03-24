<?php

namespace Directus\Custom\Hooks\Users;

use Directus\Application\Application;
use Directus\Hook\HookInterface;
use Directus\Hook\Payload;
use Directus\Util\DateTimeUtils;
use Directus\Util\JWTUtils;
use Directus\Mail\Message;
use Swift_RfcComplianceException;
use Swift_TransportException;
use function Directus\send_mail_with_template;
use function Directus\get_directus_setting;

class AfterCreateUser implements HookInterface
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
        $basePath = $container['path_base'];
        try {
            $auth = $container->get('auth');
            $datetime = DateTimeUtils::nowInUTC();
            $invitationToken = $auth->generateInvitationToken([
                'date' => $datetime->toString(),
                'exp' => $datetime->inDays(30)->getTimestamp(),
                'email' => $payload['email'],
                'id' => $payload['id'],
            ]);

            $email = $payload['email'];
            $data = ['token' => $invitationToken];
            send_mail_with_template('custom-user-invitation.twig', $data, function (Message $message) use ($email) {
                $message->setSubject(
                    sprintf('Invitation to Instance: %s', get_directus_setting('project_name', ''))
                );
                $message->setTo($email);
            });
        } catch (Swift_RfcComplianceException $ex) {

        } catch (Swift_TransportException $ex) {

        }
    }
}
