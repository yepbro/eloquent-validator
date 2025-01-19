<?php

namespace YepBro\EloquentValidator;

use Illuminate\Database\Eloquent\Model;
use YepBro\EloquentValidator\Exceptions\ModelNotValidated;
use YepBro\EloquentValidator\Exceptions\ModelValidatorNotFound;
use YepBro\EloquentValidator\Tests\HasValidatorTrait\GetModelValidatorClassPathTest;
use YepBro\EloquentValidator\Tests\HasValidatorTrait\GetValidatorInstanceTest;

/**
 * @property string<class-string> $validatorClass
 */
trait HasValidator
{
    private ModelValidator $validatorInstance;

    /**
     * @throws ModelValidatorNotFound
     * @see GetValidatorInstanceTest
     */
    public function getModelValidatorInstance(): ModelValidator
    {
        if (!isset($this->validatorInstance)) {
            $validatorClass = $this->getModelValidatorClass(get_class($this));

            if (!class_exists($validatorClass)) {
                throw new ModelValidatorNotFound($validatorClass);
            }

            $this->validatorInstance = new $validatorClass($this);
        }

        return $this->validatorInstance;
    }

    /**
     * Получить класс валидатора по имени модели (с учетом вложенности) или его предустановленное значение
     *
     * @see GetModelValidatorClassPathTest
     */
    protected function getModelValidatorClass(string $modelPath): string
    {
        if (isset($this->validatorClass)) {
            return $this->validatorClass;
        }

        $modelNamespace = $this->getModelNamespace();

        $validatorNamespace = $this->getModelValidatorNamespace();

        return str_replace($modelNamespace, $validatorNamespace, $modelPath) . 'Validator';
    }

    /**
     * @throws ModelValidatorNotFound
     * @throws ModelNotValidated
     */
    public function validate(): void
    {
        $this->getModelValidatorInstance()->validate();
    }

    /**
     * @throws ModelValidatorNotFound
     */
    public function validationFails(): bool
    {
        return $this->getModelValidatorInstance()->fails();
    }

    /**
     * @throws ModelValidatorNotFound
     */
    public function validationPasses(): bool
    {
        return $this->getModelValidatorInstance()->passes();
    }

    /**
     * @throws ModelValidatorNotFound
     */
    public function getValidationErrors(): array
    {
        return $this->getModelValidatorInstance()->getErrorsAsArray();
    }


    /**
     * @param int $options Options for json_encode. Default: JSON_UNESCAPED_UNICODE
     * @return string
     * @throws ModelValidatorNotFound
     */
    public function getValidationErrorsAsJson(int $options = JSON_UNESCAPED_UNICODE): string
    {
        return $this->getModelValidatorInstance()->getErrorsAsJson($options);
    }

    public function saveWithoutValidation(): Model
    {
        return parent::save();
    }

    public function saveWithValidation(): Model
    {
        return parent::save();
    }

    /**
     * Получить пространство имен для моделей
     * TODO: from config
     */
    protected function getModelNamespace(): string
    {
        return "App\\Models\\";
    }

    /**
     * Получить пространство имен для валидаторов
     * TODO: from config
     */
    protected function getModelValidatorNamespace(): string
    {
        return "App\\ModelValidators\\";
    }
}