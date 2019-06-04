<?php

use Directus\Application\Http\Request;
use Directus\Application\Http\Response;
use Directus\Application\Route;
use Directus\Authentication\Exception\ExpiredResetPasswordToken;
use Directus\Authentication\Exception\InvalidResetPasswordTokenException;
use Directus\Authentication\Exception\UserNotFoundException;
use Directus\Exception\InvalidPayloadException;
use Directus\Util\JWTUtils;
use Directus\Custom\Exceptions\WeakPasswordException;
use Directus\Custom\Exceptions\PasswordMatchCredentialsException;

class ResetPassword extends Route
{
    public function __invoke(Request $request, Response $response)
    {
        if (!$request->getParsedBodyParam('new_password', null)) {
            throw new InvalidPayloadException();
        }

        $this->resetPasswordWithToken(
            $request->getAttribute('token'),
            $request->getParsedBodyParam('new_password')
        );

        return $this->responseWithData($request, $response, []);
    }

    protected function resetPasswordWithToken($token, $newPassword)
    {
        if (!JWTUtils::isJWT($token)) {
            throw new InvalidResetPasswordTokenException($token);
        }

        if (JWTUtils::hasExpired($token)) {
            throw new ExpiredResetPasswordToken($token);
        }

        $payload = JWTUtils::getPayload($token);

        if (!JWTUtils::hasPayloadType(JWTUtils::TYPE_RESET_PASSWORD, $payload)) {
            throw new InvalidResetPasswordTokenException($token);
        }

        if (!$this->isStrongPassword($newPassword)) {
            throw new WeakPasswordException('Password is too weak');
        }

        /** @var Provider $auth */
        $auth = $this->container->get('auth');
        $auth->validatePayloadOrigin($payload);

        $userProvider = $auth->getUserProvider();
        $user = $userProvider->find($payload->id);

        if (!$user) {
            throw new UserNotFoundException();
        }

        $userCredentials = [
            mb_strtolower($user->getEmail()),
            mb_strtolower($user->get('first_name')),
            mb_strtolower($user->get('last_name')),
        ];
        if (in_array(mb_strtolower($newPassword), $userCredentials)) {
            throw new PasswordMatchCredentialsException('Password matches email, first name or last name');
        }

        // Throw invalid token if the payload email is not the same as the current user email
        if (!property_exists($payload, 'email') || $payload->email !== $user->getEmail()) {
            throw new InvalidResetPasswordTokenException($token);
        }

        $userProvider->update($user, [
            'password' => $auth->hashPassword($newPassword),
        ]);
    }

    /**
     * Checks password strength
     *
     * @param string $password Password
     *
     * @return bool
     */
    protected function isStrongPassword($password)
    {
        return mb_strlen($password, mb_detect_encoding($password)) >= 8
            && preg_match('/[A-Z]/', $password) === 1
            && preg_match('/[a-z]/', $password) === 1
            && preg_match('/\d/', $password) === 1;
    }
}
