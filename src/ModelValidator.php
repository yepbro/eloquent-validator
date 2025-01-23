<?php
declare(strict_types=1);

namespace YepBro\EloquentValidator;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator as ValidatorFacade;
use Illuminate\Validation\Factory;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;
use YepBro\EloquentValidator\Exceptions\ModelNotValidated;
use YepBro\EloquentValidator\Tests\Unit\ModelValidator\FailsTest;
use YepBro\EloquentValidator\Tests\Unit\ModelValidator\GetActionRulesTest;
use YepBro\EloquentValidator\Tests\Unit\ModelValidator\GetErrorsAsArrayTest;
use YepBro\EloquentValidator\Tests\Unit\ModelValidator\GetModelDataTest;
use YepBro\EloquentValidator\Tests\Unit\ModelValidator\GetRulesKeysTest;
use YepBro\EloquentValidator\Tests\Unit\ModelValidator\GetValidatorTest;
use YepBro\EloquentValidator\Tests\Unit\ModelValidator\PassesTest;
use YepBro\EloquentValidator\Tests\Unit\ModelValidator\PropertiesTest;
use YepBro\EloquentValidator\Tests\Unit\ModelValidator\ValidateTest;

abstract class ModelValidator
{
    /** @var array<string, string|array<int, string|Rule|ValidationRule>> */
    protected array $rules = [];

    /** @var array<string, string|array<int, string|Rule|ValidationRule>> */
    protected array $updateRules = [];

    /** @var array<string, string|array<int, string|Rule|ValidationRule>> */
    protected array $createRules = [];

    /** @var array<string, string> */
    protected array $messages = [];

    /** @var array<string, string> */
    protected array $attributes = [];

    protected Validator $validator;

    public function __construct(protected readonly Model $model)
    {
        //
    }

    /**
     * Создать новый инстанс Laravel-валидатора
     */
    protected function validatorFactory(): Factory
    {
        // @phpstan-ignore return.type
        return ValidatorFacade::getFacadeRoot();
    }

    /**
     * Получить инстанс Laravel-валидатора с заполненными данными
     *
     * @see GetValidatorTest
     */
    public function getValidator(): Validator
    {
        if (!isset($this->validator)) {
            $this->validator = $this->validatorFactory()->make(
                data: $this->getModelData(),
                rules: $this->getActionRules(),
                messages: $this->getMessages(),
                attributes: $this->getAttributes(),
            );
        }

        return $this->validator;
    }

    /**
     * Проверить данные, если есть ошибка, то выбросить исключение
     *
     * @throws ModelNotValidated
     * @see ValidateTest
     */
    public function validate(): void
    {
        try {
            $this->getValidator()->validated();
        } catch (ValidationException $exception) {
            /** @var array<int, array<int, string>> $errors */
            $errors = $exception->errors();
            throw new ModelNotValidated($this->model::class, $errors);
        }
    }

    /**
     * Проверить, что валидация прошла успешно
     *
     * @see PassesTest
     */
    public function passes(): bool
    {
        return $this->getValidator()->passes();
    }

    /**
     * Проверить, что есть ошибки валидации
     *
     * @see FailsTest
     */
    public function fails(): bool
    {
        return $this->getValidator()->fails();
    }

    /**
     * Получить массив с ошибками валидации
     *
     * @return array<string, string[]>
     * @see GetErrorsAsArrayTest
     */
    public function getErrorsAsArray(): array
    {
        return $this->getValidator()->errors()->toArray(); // @phpstan-ignore return.type
    }

    /**
     * Получить json-строку с ошибками валидации
     *
     * @see GetErrorsAsJsonTest
     */
    public function getErrorsAsJson(int $options = 0): string
    {
        return $this->getValidator()->errors()->toJson($options);
    }

    /**
     * Получить массив с правилами валидации для определенного типа операции с моделью (создание или обновление)
     *
     * @return array<string, string|array<int, string|Rule|ValidationRule>>
     * @see GetActionRulesTest
     */
    protected function getActionRules(?ActionEnum $action = null): array
    {
        $rules = ($action && $action === ActionEnum::UPDATE) || ($action === null && $this->model->exists)
            ? $this->getUpdateRules()
            : $this->getCreateRules();

        return array_filter(array_merge($this->getRules(), $rules));
    }

    /**
     * Получить данные модели для полей участвующих в валидации
     *
     * Тип операции определяется по переданному аргументу или, если он отсутствует, по свойству exists модели
     *
     * @return array<string, mixed>
     * @see GetModelDataTest
     */
    protected function getModelData(): array
    {
        return array_combine(
            $this->getUsedRulesKeys(),
            array_map(fn($key) => $this->model->getAttributes()[$key] ?? null, $this->getUsedRulesKeys()),
        );
    }

    /**
     * Получить массив ключей правил валидации для определенного типа операции с моделью (создание или обновление)
     *
     * Тип операции определяется по переданному аргументу или, если он отсутствует, по свойству exists модели
     *
     * @return string[]
     * @see GetRulesKeysTest
     */
    protected function getUsedRulesKeys(?ActionEnum $action = null): array
    {
        return array_keys($this->getActionRules($action));
    }

    /**
     * Clears the validator and returns the current instance
     *
     * @see ClearValidatorTest
     */
    protected function clearValidator(): ModelValidator
    {
        unset($this->validator);
        return $this;
    }

    /** ===============================================================================================================
     * Getters & Setters & Modifiers
     * ================================================================================================================
     */

    /**
     * @return array<string, string|array<int, string|Rule|ValidationRule>>
     * @see PropertiesTest
     */
    public function getRules(): array
    {
        return $this->rules;
    }

    /**
     * @param array<string, string|array<int, string|Rule|ValidationRule>> $rules
     * @see PropertiesTest
     */
    public function setRules(array $rules): ModelValidator
    {
        $this->rules = $rules;
        $this->clearValidator();
        return $this;
    }

    /**
     * @param string|Rule|ValidationRule|array<int, string|Rule|ValidationRule> $rules
     * @see PropertiesTest
     */
    public function addRule(string $key, string|array|Rule|ValidationRule $rules): ModelValidator
    {
        $this->rules = array_merge($this->rules, [$key => $this->parseRules($rules)]);
        $this->clearValidator();
        return $this;
    }

    /** @see PropertiesTest */
    public function clearRules(): ModelValidator
    {
        $this->rules = [];
        $this->clearValidator();
        return $this;
    }

    /**
     * @return array<string, string|array<int, string|Rule|ValidationRule>>
     * @see PropertiesTest
     */
    public function getUpdateRules(): array
    {
        return $this->updateRules;
    }

    /**
     * @param array<string, string|array<int, string|Rule|ValidationRule>> $updateRules
     * @see PropertiesTest
     */
    public function setUpdateRules(array $updateRules): ModelValidator
    {
        $this->updateRules = $updateRules;
        $this->clearValidator();
        return $this;
    }

    /**
     * @param string|Rule|ValidationRule|array<int, string|Rule|ValidationRule> $rules
     * @see PropertiesTest
     */
    public function addUpdateRule(string $key, string|array|Rule|ValidationRule $rules): ModelValidator
    {
        $this->updateRules = array_merge($this->updateRules, [$key => $this->parseRules($rules)]);
        $this->clearValidator();
        return $this;
    }

    /** @see PropertiesTest */
    public function clearUpdateRules(): ModelValidator
    {
        $this->updateRules = [];
        $this->clearValidator();
        return $this;
    }

    /**
     * @return array<string, string|array<int, string|Rule|ValidationRule>>
     * @see PropertiesTest
     */
    public function getCreateRules(): array
    {
        return $this->createRules;
    }

    /**
     * @param array<string, string|array<int, string|Rule|ValidationRule>> $createRules
     * @see PropertiesTest
     */
    public function setCreateRules(array $createRules): ModelValidator
    {
        $this->createRules = $createRules;
        $this->clearValidator();
        return $this;
    }

    /**
     * @param string|Rule|ValidationRule|array<int, string|Rule|ValidationRule> $rules
     * @see PropertiesTest
     */
    public function addCreateRule(string $key, string|array|Rule|ValidationRule $rules): ModelValidator
    {
        $this->createRules = array_merge($this->createRules, [$key => $this->parseRules($rules)]);
        $this->clearValidator();
        return $this;
    }

    /** @see PropertiesTest */
    public function clearCreateRules(): ModelValidator
    {
        $this->createRules = [];
        $this->clearValidator();
        return $this;
    }

    /**
     * @return array<string, string>
     * @see PropertiesTest
     */
    public function getMessages(): array
    {
        return $this->messages;
    }

    /**
     * @param array<string, string> $messages
     * @see PropertiesTest
     */
    public function setMessages(array $messages): ModelValidator
    {
        $this->messages = $messages;
        $this->clearValidator();
        return $this;
    }

    /**
     * @see PropertiesTest
     */
    public function addMessage(string $key, string $value): ModelValidator
    {
        $this->messages = array_merge($this->messages, [$key => $value]);
        $this->clearValidator();
        return $this;
    }

    /** @see PropertiesTest */
    public function clearMessages(): ModelValidator
    {
        $this->messages = [];
        $this->clearValidator();
        return $this;
    }

    /**
     * @return array<string, string>
     * @see PropertiesTest
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param array<string, string> $attributes
     * @see PropertiesTest
     */
    public function setAttributes(array $attributes): ModelValidator
    {
        $this->attributes = $attributes;
        $this->clearValidator();
        return $this;
    }

    /**
     * @see PropertiesTest
     */
    public function addAttribute(string $key, string $value): ModelValidator
    {
        $this->attributes = array_merge($this->attributes, [$key => $value]);
        $this->clearValidator();
        return $this;
    }

    /** @see PropertiesTest */
    public function clearAttributes(): ModelValidator
    {
        $this->attributes = [];
        $this->clearValidator();
        return $this;
    }

    /**
     * @param string|Rule|ValidationRule|array<int, string|Rule|ValidationRule> $rules
     * @return array<int, string|Rule|ValidationRule>
     */
    protected function parseRules(string|array|Rule|ValidationRule $rules): array
    {
        return match (true) {
            $rules instanceof Rule, $rules instanceof ValidationRule => [$rules],
            is_string($rules) => explode('|', $rules),
            default => $rules,
        };
    }
}