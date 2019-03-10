<?php

namespace Directus\Custom\Hooks\Profiles;

use Directus\Hook\HookInterface;
use Directus\Hook\Payload;
use Directus\Application\Application;

use Directus\Custom\Exceptions\UnprocessablePhoneException;
use Directus\Custom\Exceptions\UnprocessableSecondPhoneException;
use Directus\Custom\Exceptions\UnprocessableHomeAddressException;

use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;

class BeforeUpdateProfiles implements HookInterface
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
        $logger->info('BeforeUpdateProfiles', ['payload' => $payload->getData()]);

        // first phone validation
        if ($payload->has('phone_1')) {

            if ($payload->get('phone_1') !== '') {
                $phoneUtil = PhoneNumberUtil::getInstance();
                $phoneError = 'נא להזין מספר טלפון תקין';
                try {
                    $numberProto = $phoneUtil->parse($payload->get('phone_1'), 'IL');
                    if (!$phoneUtil->isValidNumber($numberProto)) {
                        throw new UnprocessablePhoneException($phoneError);
                    }
                    $payload->set(
                        'phone_1',
                        $phoneUtil->format($numberProto, PhoneNumberFormat::E164)
                    );
                } catch (NumberParseException $e) {
                    throw new UnprocessablePhoneException($phoneError);
                }
            } else {
                $payload->set('phone_1', null);
            }
        }

        // secondary phone validation
        if ($payload->has('phone_2')) {

            if ($payload->get('phone_2') !== '') {
                $phoneUtil = PhoneNumberUtil::getInstance();
                $secondPhoneError = 'נא להזין מספר טלפון תקין';
                try {
                    $numberProto = $phoneUtil->parse($payload->get('phone_2'), 'IL');
                    if (!$phoneUtil->isValidNumber($numberProto)) {
                        throw new UnprocessablePhoneException($secondPhoneError);
                    }
                    $payload->set(
                        'phone_2',
                        $phoneUtil->format($numberProto, PhoneNumberFormat::E164)
                    );
                } catch (NumberParseException $e) {
                    throw new UnprocessableSecondPhoneException($secondPhoneError);
                }
            } else {
                $payload->set('phone_2', null);
            }
        }

        // home address validation
        if ($payload->has('home_address')) {

            if ($payload->get('home_address') !== '') {
                $validator = Validation::createValidator();
                $violations = $validator->validate($payload->get('home_address'), [
                    new Length([
                        'max' => 200,
                        'maxMessage' => 'Home address must be shorter 200 chars',
                    ]),
                ]);

                if (count($violations) !== 0) {
                    throw new UnprocessableHomeAddressException($violations[0]->getMessage());
                }
            } else {
                $payload->set('home_address', null);
            }
        }

        // make sure to return the payload
        return $payload;
    }
}
