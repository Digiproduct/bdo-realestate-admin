<?php

namespace Directus\Custom\Exceptions;

use Directus\Exception\UnprocessableEntityExceptionInterface;
use Directus\Exception\Exception;

class UnprocessableFirstNameException extends Exception implements UnprocessableEntityExceptionInterface
{
    const ERROR_CODE = 'invalid_first_name';
}
