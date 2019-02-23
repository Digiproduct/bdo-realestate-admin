<?php

namespace Directus\Custom\Exceptions;

use Directus\Exception\UnprocessableEntityExceptionInterface;
use Directus\Exception\Exception;

class UnprocessableSecondPhoneException extends Exception implements UnprocessableEntityExceptionInterface
{
    const ERROR_CODE = 'invalid_phone_2';
}
