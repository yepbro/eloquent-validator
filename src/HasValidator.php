<?php
declare(strict_types=1);

namespace YepBro\EloquentValidator;

use Illuminate\Database\Eloquent\Model;
use Throwable;
use YepBro\EloquentValidator\Exceptions\ModelNotValidated;
use YepBro\EloquentValidator\Exceptions\ModelValidatorNotFound;
use YepBro\EloquentValidator\Tests\Unit\HasValidatorTrait\GetModelValidatorClassPathTest;
use YepBro\EloquentValidator\Tests\Unit\HasValidatorTrait\GetNamespaceTest;
use YepBro\EloquentValidator\Tests\Unit\HasValidatorTrait\GetValidationErrorsAsJsonTest;
use YepBro\EloquentValidator\Tests\Unit\HasValidatorTrait\GetValidationErrorsTest;
use YepBro\EloquentValidator\Tests\Unit\HasValidatorTrait\GetValidatorInstanceTest;
use YepBro\EloquentValidator\Tests\Unit\HasValidatorTrait\ValidateTest;
use YepBro\EloquentValidator\Tests\Unit\HasValidatorTrait\ValidationFailsTest;
use YepBro\EloquentValidator\Tests\Unit\HasValidatorTrait\ValidationPassesTest;
use YepBro\EloquentValidator\Tests\Unit\HasValidatorTrait\WithValidationTest;
use function config;

/**
 * @property string<class-string> $validatorClass
 * @mixin Model
 * @phpstan-ignore trait.unused
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

            $this->validatorInstance = new $validatorClass($this::class, $this->getAttributes(), $this->exists);
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
     * @throws ModelValidatorNotFound|ModelNotValidated
     * @see ValidateTest
     */
    public function validate(): static
    {
        $this->getModelValidatorInstance()->validate();

        return $this;
    }

    /**
     * Проверить, что есть ошибки валидации
     *
     * @throws ModelValidatorNotFound
     * @see ValidationFailsTest
     */
    public function validationFails(): bool
    {
        return $this->getModelValidatorInstance()->fails();
    }

    /**
     * Проверить, что валидация прошла успешно
     *
     * @throws ModelValidatorNotFound
     * @see ValidationPassesTest
     */
    public function validationPasses(): bool
    {
        return $this->getModelValidatorInstance()->passes();
    }

    /**
     * Получить массив ошибок валидации
     *
     * @throws ModelValidatorNotFound
     * @see GetValidationErrorsTest
     */
    public function getValidationErrors(): array
    {
        return $this->getModelValidatorInstance()->getErrorsAsArray();
    }

    /**
     * Получить ошибки валидации в виде json-строки
     *
     * @param int $options Options for json_encode. Default: JSON_UNESCAPED_UNICODE
     * @throws ModelValidatorNotFound
     * @see GetValidationErrorsAsJsonTest
     */
    public function getValidationErrorsAsJson(int $options = JSON_UNESCAPED_UNICODE): string
    {
        return $this->getModelValidatorInstance()->getErrorsAsJson($options);
    }

    /**
     * Сохранить модель с предварительной валидации (когда режим обязательной валидации выключен)
     *
     * @throws ModelNotValidated|ModelValidatorNotFound
     * @see WithValidationTest
     */
    public function saveWithValidation(array $options = []): bool
    {
        return $this->validate()->save($options);
    }

    /**
     * @throws ModelNotValidated|ModelValidatorNotFound
     * @throws Throwable
     * @see WithValidationTest
     */
    public function saveOrFailWithValidation(array $options = []): bool
    {
        return $this->validate()->saveOrFail($options);
    }

    /**
     * @throws ModelNotValidated|ModelValidatorNotFound
     * @see WithValidationTest
     */
    public function saveQuietlyWithValidation(array $options = []): bool
    {
        return $this->validate()->saveQuietly($options);
    }

    /**
     * @throws ModelNotValidated|ModelValidatorNotFound
     * @see WithValidationTest
     */
    public function updateWithValidation(array $attributes = [], array $options = []): bool
    {
        if (!$this->exists) {
            return false;
        }

        return $this->fillWithValidation($attributes)->save($options);
    }

    /**
     * @throws ModelNotValidated|ModelValidatorNotFound
     * @throws Throwable
     * @see WithValidationTest
     */
    public function updateOrFailWithValidation(array $attributes = [], array $options = []): bool
    {
        if (!$this->exists) {
            return false;
        }

        return $this->fillWithValidation($attributes)->saveOrFail($options);
    }

    /**z
     * @throws ModelNotValidated|ModelValidatorNotFound
     * @see WithValidationTest
     */
    public function updateQuietlyWithValidation(array $attributes = [], array $options = []): bool
    {
        if (!$this->exists) {
            return false;
        }

        return $this->fillWithValidation($attributes)->saveQuietly($options);
    }

    /**
     * @throws ModelNotValidated|ModelValidatorNotFound
     * @see WithValidationTest
     */
    public function fillWithValidation(array $attributes = []): static
    {
        return $this->fill($attributes)->validate();
    }

    /**
     * @throws ModelNotValidated|ModelValidatorNotFound
     * @see WithValidationTest
     */
    public function forceFillWithValidation(array $attributes = []): static
    {
        return $this->forceFill($attributes)->validate();
    }

    /**
     * Получить пространство имен для моделей
     *
     * @see GetNamespaceTest
     */
    protected function getModelNamespace(): string
    {
        return config(Constants::KEY . '.models_namespace', 'App\Models');
    }

    /**
     * Получить пространство имен для валидаторов моделей
     *
     * @see GetNamespaceTest
     */
    protected function getModelValidatorNamespace(): string
    {
        return config(Constants::KEY . '.validators_namespace', 'App\Validators');
    }
}