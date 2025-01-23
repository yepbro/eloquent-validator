<?php
declare(strict_types=1);

namespace YepBro\EloquentValidator\Exceptions;

use Exception;

class EloquentValidatorException extends Exception
{
    /** @var string */
    protected $message;

    /** @var int */
    protected $code;
}