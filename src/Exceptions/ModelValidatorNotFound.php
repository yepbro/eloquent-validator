<?php

namespace YepBro\EloquentValidator\Exceptions;

class ModelValidatorNotFound extends EloquentValidatorException
{
    public function __construct(string $class)
    {
        parent::__construct();

        $this->message = "Class $class does not exist";
    }
}