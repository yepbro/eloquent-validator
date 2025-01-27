<?php

declare(strict_types=1);

namespace YepBro\EloquentValidator\Exceptions;

class ModelValidatorNotFound extends EloquentValidatorException
{
    public function __construct(string $class)
    {
        $message = "Class $class does not exist";

        parent::__construct($message, $this->code, $this->getPrevious());
    }
}
