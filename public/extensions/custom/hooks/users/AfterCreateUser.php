<?php

namespace Directus\Custom\Hooks\Users;

use Directus\Application\Application;
use Directus\Hook\HookInterface;
use Directus\Hook\Payload;
use Directus\Util\DateTimeUtils;
use Directus\Util\JWTUtils;
use Swift_RfcComplianceException;
use function Directus\send_user_invitation_email;

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
                'exp' => $datetime->inDays(30)->toString(),
                'email' => $payload['email'],
                'sender' => $container->get('acl')->getUserId(),
            ]);
            send_user_invitation_email($payload['email'], $invitationToken);
        } catch (Swift_RfcComplianceException $ex) {

        }
    }
}
