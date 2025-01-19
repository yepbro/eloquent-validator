<?php

namespace YepBro\EloquentValidator;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Translation\Translator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;
use YepBro\EloquentValidator\Exceptions\ModelNotValidated;

abstract class ModelValidator
{
    protected array $rules = [];
    protected array $updatedRules = [];
    protected array $createdRules = [];
    protected array $messages = [];
    protected array $attributes = [];
    protected Validator $validator;

    public function __construct(private readonly Model $model)
    {
        //
    }

    public function getValidator(): Validator
    {
        if (!isset($this->validator)) {
            $this->validator = new Validator(
                new Translator(), // TODO: translator
                $this->getModelData(),
                $this->getRules(),
                $this->messages,
                $this->attributes,
            );
        }

        return $this->validator;
    }

    /**
     * @throws ModelNotValidated
     */
    public function validate(): void
    {
        try {
            $this->getValidator()->validated();
        } catch (ValidationException $exception) {
            // TODO: передавать сообщение об ошибке и сами ошибки
            throw new ModelNotValidated();
        }
    }

    public function passes(): bool
    {
        return $this->getValidator()->passes();
    }

    public function fails(): bool
    {
        return $this->getValidator()->fails();
    }

    public function getErrorsAsArray(): array
    {
        return $this->getValidator()->errors()->toArray();
    }

    public function getErrorsAsJson(int $options = 0): string
    {
        return $this->getValidator()->errors()->toJson($options);
    }

    protected function getRules(): array
    {
        $rules = $this->model->exists ? $this->updatedRules : $this->createdRules;

        return array_merge($this->rules, $rules);
    }

    protected function getModelData(): array
    {
        return array_map(fn($key) => $this->model->getRawOriginal($key), $this->getKeys());
    }

    protected function getKeys(): array
    {
        return array_keys($this->rules);
    }
}