<?php

namespace Directus\Custom\Exceptions;

use Directus\Exception\UnprocessableEntityExceptionInterface;
use Directus\Exception\Exception;

class PasswordMatchCredentialsException extends Exception implements UnprocessableEntityExceptionInterface
{
    const ERROR_CODE = 'match_credentials';
}
