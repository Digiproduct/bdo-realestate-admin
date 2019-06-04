<?php

namespace Directus\Custom\Exceptions;

use Directus\Exception\UnprocessableEntityExceptionInterface;
use Directus\Exception\Exception;

class WeakPasswordException extends Exception implements UnprocessableEntityExceptionInterface
{
    const ERROR_CODE = 'weak_password';
}
