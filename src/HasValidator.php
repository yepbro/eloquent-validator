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
    public function getValidatorInstance(): ModelValidator
    {
        if (!isset($this->validatorInstance)) {
            $validatorClass = $this->getModelValidatorClass(get_class($this));

            if (!class_exists($validatorClass)) {
                throw new ModelValidatorNotFound($validatorClass);
            }

            $this->validatorInstance = new $validatorClass;
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
     * @throws ModelNotValidated
     */
    public function validate(): void
    {
        throw new ModelNotValidated;
    }

    public function fails(): bool
    {
        return true;
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