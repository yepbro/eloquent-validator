<?php
declare(strict_types=1);

namespace YepBro\EloquentValidator;

use Illuminate\Database\Eloquent\Model;
use YepBro\EloquentValidator\Exceptions\ModelNotValidated;
use YepBro\EloquentValidator\Exceptions\ModelValidatorNotFound;
use YepBro\EloquentValidator\Tests\Unit\HasValidatorTrait\GetModelValidatorClassPathTest;
use YepBro\EloquentValidator\Tests\Unit\HasValidatorTrait\GetValidatorInstanceTest;

/**
 * @property string<class-string> $validatorClass
 * @mixin Model
 */
trait HasValidator
{
    private ModelValidator $validatorInstance;

    /**
     * Получить инстанс валидатора модели
     *
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
     * Получить имя класса валидатора по имени модели (с учетом вложенности) или на основе предустановленного значения
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
     * Проверить данные, если есть ошибка, то выбросить исключение
     *
     * @throws ModelValidatorNotFound
     * @throws ModelNotValidated
     */
    public function validate(): void
    {
        $this->getModelValidatorInstance()->validate();
    }

    /**
     * Проверить, что есть ошибки валидации
     *
     * @throws ModelValidatorNotFound
     */
    public function validationFails(): bool
    {
        return $this->getModelValidatorInstance()->fails();
    }

    /**
     * Проверить, что валидация прошла успешно
     *
     * @throws ModelValidatorNotFound
     */
    public function validationPasses(): bool
    {
        return $this->getModelValidatorInstance()->passes();
    }

    /**
     * Получить массив ошибок валидации
     *
     * @throws ModelValidatorNotFound
     */
    public function getValidationErrors(): array
    {
        return $this->getModelValidatorInstance()->getErrorsAsArray();
    }

    /**
     * Получить ошибки валидации в виде json-строки
     *
     * @param int $options Options for json_encode. Default: JSON_UNESCAPED_UNICODE
     * @return string
     * @throws ModelValidatorNotFound
     */
    public function getValidationErrorsAsJson(int $options = JSON_UNESCAPED_UNICODE): string
    {
        return $this->getModelValidatorInstance()->getErrorsAsJson($options);
    }

    /**
     * Сохранить модель без предварительной валидации (когда режим обязательной валидации включен)
     */
    public function saveWithoutValidation(): bool
    {
        return parent::save();
    }

    /**
     * Сохранить модель с предварительной валидации (когда режим обязательной валидации выключен)
     */
    public function saveWithValidation(): bool
    {
        return parent::save();
    }

    /**
     * Получить пространство имен для моделей приложения
     * TODO: from config
     */
    protected function getModelNamespace(): string
    {
        return "App\\Models\\";
    }

    /**
     * Получить пространство имен для валидаторов приложения
     * TODO: from config
     */
    protected function getModelValidatorNamespace(): string
    {
        return "App\\ModelValidators\\";
    }
}