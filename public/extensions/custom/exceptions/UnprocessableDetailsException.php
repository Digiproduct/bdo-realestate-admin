<?php

namespace Directus\Custom\Exceptions;

use Directus\Exception\UnprocessableEntityExceptionInterface;
use Directus\Exception\Exception;

class UnprocessableDetailsException extends Exception implements UnprocessableEntityExceptionInterface
{
    const ERROR_CODE = 'invalid_details';
}
