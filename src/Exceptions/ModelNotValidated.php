<?php

namespace YepBro\EloquentValidator\Exceptions;

class ModelNotValidated extends EloquentValidatorException
{
    public function __construct(string $modelName, public readonly array $errors)
    {
        $this->message = "Model $modelName not validated";

        parent::__construct($this->message, $this->code, $this->getPrevious());
    }
}