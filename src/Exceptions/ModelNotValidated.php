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
        $message = "Model $modelName not validated";

        parent::__construct($message, $this->code, $this->getPrevious());
    }

    /**
     * @return array<int, array<int, string>>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}