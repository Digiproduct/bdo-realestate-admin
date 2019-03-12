<?php

use Directus\Application\Http\Request;
use Directus\Application\Http\Response;
use Directus\Application\Route;
use Directus\Authentication\Exception\ExpiredResetPasswordToken;
use Directus\Authentication\Exception\InvalidResetPasswordTokenException;
use Directus\Authentication\Exception\UserNotFoundException;
use Directus\Exception\InvalidPayloadException;
use Directus\Util\JWTUtils;
use Directus\Mail\Message;
use function Directus\send_mail_with_template;
use function Directus\get_directus_setting;
use function Directus\get_user_full_name;

class ForgotPassword extends Route
{
    public function __invoke(Request $request, Response $response)
    {
        $this->validateRequestPayload($request);

        try {
            $this->sendResetPasswordToken(
                $request->getParsedBodyParam('email')
            );
        } catch (\Exception $e) {
            $this->container->get('logger')->error($e);
        }

        return $this->responseWithData($request, $response, []);
    }

    /**
     * Sends a email with the reset password token
     *
     * @param $email
     */
    protected function sendResetPasswordToken($email)
    {
        /** @var AuthService $authService */
        $authService = $this->container->get('services')->get('auth');
        $authService->validate(['email' => $email], ['email' => 'required|email']);

        /** @var Provider $auth */
        $auth = $this->container->get('auth');
        $user = $auth->findUserWithEmail($email);

        $resetToken = $auth->generateResetPasswordToken($user);

        $this->send_forgot_password_email($user->toArray(), $resetToken);
    }

    /**
     * Sends a new reset password email
     *
     * @param array $user
     * @param string $token
     */
    protected function send_forgot_password_email(array $user, $token)
    {
        $data = [
            'reset_token' => $token,
            'user_full_name' => get_user_full_name($user),
        ];
        send_mail_with_template('custom-forgot-password.twig', $data, function (Message  $message) use ($user) {
            $message->setSubject(
                sprintf('Password Reset Request: %s', get_directus_setting('project_name', ''))
            );
            $message->setTo($user['email']);
        });
    }
}
