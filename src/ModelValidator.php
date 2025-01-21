<?php

namespace YepBro\EloquentValidator;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator as ValidatorFacade;
use Illuminate\Validation\Factory;
use Illuminate\Validation\Rule;
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
    protected array $rules = [];

    protected array $updateRules = [];

    protected array $createRules = [];

    protected array $messages = [];

    protected array $attributes = [];

    protected Validator $validator;

    public function __construct(protected readonly Model $model)
    {
        //
    }

    /** uncovered */
    protected function validatorFactory(): Factory
    {
        return ValidatorFacade::getFacadeRoot();
    }

    /** @see GetValidatorTest */
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
     * @throws ModelNotValidated
     * @see ValidateTest
     */
    public function validate(): void
    {
        try {
            $this->getValidator()->validated();
        } catch (ValidationException $exception) {
            throw new ModelNotValidated($this->model::class, $exception->errors());
        }
    }

    /** @see PassesTest */
    public function passes(): bool
    {
        return $this->getValidator()->passes();
    }

    /** @see FailsTest */
    public function fails(): bool
    {
        return $this->getValidator()->fails();
    }

    /**  @see GetErrorsAsArrayTest */
    public function getErrorsAsArray(): array
    {
        return $this->getValidator()->errors()->toArray();
    }

    /** @see GetErrorsAsJsonTest */
    public function getErrorsAsJson(int $options = 0): string
    {
        return $this->getValidator()->errors()->toJson($options);
    }

    /** @see GetActionRulesTest */
    protected function getActionRules(?ActionEnum $action = null): array
    {
        $rules = ($action && $action === ActionEnum::UPDATE) || ($action === null && $this->model->exists)
            ? $this->getUpdateRules()
            : $this->getCreateRules();

        return array_filter(array_merge($this->getRules(), $rules));
    }

    /** @see GetModelDataTest */
    protected function getModelData(): array
    {
        return array_combine(
            $this->getUsedRulesKeys(),
            array_map(fn($key) => $this->model->getRawOriginal($key), $this->getUsedRulesKeys()),
        );
    }

    /** @see GetRulesKeysTest */
    protected function getUsedRulesKeys(?ActionEnum $action = null): array
    {
        return array_keys($this->getActionRules($action));
    }

    /** @see ClearValidatorTest */
    protected function clearValidator(): ModelValidator
    {
        unset($this->validator);
        return $this;
    }

    /** ===============================================================================================================
     * Getters & Setters & Modifiers
     * ================================================================================================================
     */

    /** @see PropertiesTest */
    public function getRules(): array
    {
        return $this->rules;
    }

    /** @see PropertiesTest */
    public function setRules(array $rules): ModelValidator
    {
        $this->rules = $rules;
        $this->clearValidator();
        return $this;
    }

    /** @see PropertiesTest */
    public function addRule(string $key, string|array|Rule $rules): ModelValidator
    {
        $this->rules = array_merge($this->rules, [$key => $rules]);
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

    /** @see PropertiesTest */
    public function getUpdateRules(): array
    {
        return $this->updateRules;
    }

    /** @see PropertiesTest */
    public function setUpdateRules(array $updateRules): ModelValidator
    {
        $this->updateRules = $updateRules;
        $this->clearValidator();
        return $this;
    }

    /** @see PropertiesTest */
    public function addUpdateRule(string $key, string|array|Rule $rules): ModelValidator
    {
        $this->updateRules = array_merge($this->updateRules, [$key => $rules]);
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

    /** @see PropertiesTest */
    public function getCreateRules(): array
    {
        return $this->createRules;
    }

    /** @see PropertiesTest */
    public function setCreateRules(array $createRules): ModelValidator
    {
        $this->createRules = $createRules;
        $this->clearValidator();
        return $this;
    }

    /** @see PropertiesTest */
    public function addCreateRule(string $key, string|array|Rule $rules): ModelValidator
    {
        $this->createRules = array_merge($this->createRules, [$key => $rules]);
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

    /** @see PropertiesTest */
    public function getMessages(): array
    {
        return $this->messages;
    }

    /** @see PropertiesTest */
    public function setMessages(array $messages): ModelValidator
    {
        $this->messages = $messages;
        $this->clearValidator();
        return $this;
    }

    /** @see PropertiesTest */
    public function addMessage(string $key, string|array|Rule $rules): ModelValidator
    {
        $this->messages = array_merge($this->messages, [$key => $rules]);
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

    /** @see PropertiesTest */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /** @see PropertiesTest */
    public function setAttributes(array $attributes): ModelValidator
    {
        $this->attributes = $attributes;
        $this->clearValidator();
        return $this;
    }

    /** @see PropertiesTest */
    public function addAttribute(string $key, string|array|Rule $rules): ModelValidator
    {
        $this->attributes = array_merge($this->attributes, [$key => $rules]);
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
}