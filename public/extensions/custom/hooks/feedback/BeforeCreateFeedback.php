<?php

namespace Directus\Custom\Hooks\Feedback;

use Directus\Hook\HookInterface;
use Directus\Hook\Payload;
use Directus\Custom\Exceptions\UnprocessableFirstNameException;
use Directus\Custom\Exceptions\UnprocessableLastNameException;
use Directus\Custom\Exceptions\UnprocessablePhoneException;
use Directus\Custom\Exceptions\UnprocessableEmailException;
use Directus\Custom\Exceptions\UnprocessableDetailsException;

use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotBlank;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;

class BeforeCreateFeedback implements HookInterface
{
    /**
     * @param Payload $payload
     *
     * @return Payload
     */
    public function handle($payload = null)
    {
        $validator = Validation::createValidator();
        $hebrewPattern = '/\p{Hebrew}+/u';

        $firstNameError = 'First name should contain hebrew characters';
        $violations = $validator->validate($payload->get('first_name'), [
            new NotBlank([
                'message' => $firstNameError,
            ]),
            new Regex([
                'pattern' => $hebrewPattern,
                'message' => $firstNameError,
            ]),
        ]);

        if (count($violations) !== 0) {
            throw new UnprocessableFirstNameException($violations[0]->getMessage());
        }

        $lastNameError = 'Last name should contain hebrew characters';
        $violations = $validator->validate($payload->get('last_name'), [
            new NotBlank([
                'message' => $lastNameError,
            ]),
            new Regex([
                'pattern' => $hebrewPattern,
                'message' => $lastNameError,
            ]),
        ]);

        if (count($violations) !== 0) {
            throw new UnprocessableLastNameException($violations[0]->getMessage());
        }

        $phoneUtil = PhoneNumberUtil::getInstance();
        try {
            $numberProto = $phoneUtil->parse($payload->get('phone'), 'IL');
            if (!$phoneUtil->isValidNumber($numberProto)) {
                throw new UnprocessablePhoneException('נא להזין מספר טלפון תקין');
            }
            $payload->set(
                'phone',
                $phoneUtil->format($numberProto, PhoneNumberFormat::E164)
            );
        } catch (NumberParseException $e) {
            throw new UnprocessablePhoneException($e->getMessage());
        }

        $emailError = 'This value is not a valid email address.';
        $violations = $validator->validate($payload->get('email'), [
            new NotBlank([
                'message' => $emailError,
            ]),
            new Email([
                'strict' => false,
                'message' => $emailError,
                'checkMX' => false,
            ]),
        ]);

        if (count($violations) !== 0) {
            throw new UnprocessableEmailException($violations[0]->getMessage());
        }

        if ($payload->has('details')) {
            $violations = $validator->validate($payload->get('details'), [
                new Length([
                    'max' => 400,
                    'maxMessage' => 'This value cannot be large than 400 chars.',
                ]),
            ]);
            if (count($violations) !== 0) {
                throw new UnprocessableLastNameException($violations[0]->getMessage());
            }
        }

        return $payload;
    }
}
