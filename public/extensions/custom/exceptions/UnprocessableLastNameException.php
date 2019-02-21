<?php

namespace Directus\Custom\Exceptions;

use Directus\Exception\UnprocessableEntityExceptionInterface;
use Directus\Exception\Exception;

class UnprocessableLastNameException extends Exception implements UnprocessableEntityExceptionInterface
{
    const ERROR_CODE = 'invalid_last_name';
}
