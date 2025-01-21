<?php
declare(strict_types=1);

namespace YepBro\EloquentValidator\Exceptions;

class ModelNotValidated extends EloquentValidatorException
{
    /**
     * @param array<int, array<int, string>> $errors
     */
    public function __construct(string $modelName, public readonly array $errors)
    {
        $this->message = "Model $modelName not validated";

        parent::__construct($this->message, $this->code, $this->getPrevious());
    }
}