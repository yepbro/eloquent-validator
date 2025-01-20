<?php

namespace YepBro\EloquentValidator\Tests\Unit\ModelValidator;

use Illuminate\Translation\ArrayLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Validator;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\TestWith;
use YepBro\EloquentValidator\ModelValidator;
use YepBro\EloquentValidator\Tests\Unit\Mocks\MockModel;
use YepBro\EloquentValidator\Tests\Unit\Mocks\MockModelValidator;
use YepBro\EloquentValidator\Tests\Unit\UnitTestCase;

#[CoversMethod(ModelValidator::class, 'getRules')]
#[CoversMethod(ModelValidator::class, 'getAttributes')]
#[CoversMethod(ModelValidator::class, 'getMessages')]
#[CoversMethod(ModelValidator::class, 'getCreateRules')]
#[CoversMethod(ModelValidator::class, 'getUpdateRules')]
#[CoversMethod(ModelValidator::class, 'clearRules')]
#[CoversMethod(ModelValidator::class, 'clearAttributes')]
#[CoversMethod(ModelValidator::class, 'clearMessages')]
#[CoversMethod(ModelValidator::class, 'clearCreateRules')]
#[CoversMethod(ModelValidator::class, 'clearUpdateRules')]
#[CoversMethod(ModelValidator::class, 'setRules')]
#[CoversMethod(ModelValidator::class, 'setAttributes')]
#[CoversMethod(ModelValidator::class, 'setMessages')]
#[CoversMethod(ModelValidator::class, 'setCreateRules')]
#[CoversMethod(ModelValidator::class, 'setUpdateRules')]
#[CoversMethod(ModelValidator::class, 'addRule')]
#[CoversMethod(ModelValidator::class, 'addAttribute')]
#[CoversMethod(ModelValidator::class, 'addMessage')]
#[CoversMethod(ModelValidator::class, 'addCreateRule')]
#[CoversMethod(ModelValidator::class, 'addUpdateRule')]
#[Group('ModelValidator')]
class PropertiesTest extends UnitTestCase
{
    #[TestWith(['rules', ['name' => 'required'], 'getRules'])]
    #[TestWith(['attributes', ['name' => 'required'], 'getAttributes'])]
    #[TestWith(['messages', ['name' => 'required'], 'getMessages'])]
    #[TestWith(['createRules', ['name' => 'required'], 'getCreateRules'])]
    #[TestWith(['updateRules', ['name' => 'required'], 'getUpdateRules'])]
    #[TestDox('$method is ok')]
    public function test_get_property(string $property, array $value, string $method): void
    {
        $obj = $this->getMockObject($property, $value);
        $this->assertSame($value, $obj->$method());
    }

    #[TestWith(['rules', ['name' => 'required'], 'clearRules'])]
    #[TestWith(['attributes', ['name' => 'required'], 'clearAttributes'])]
    #[TestWith(['messages', ['name' => 'required'], 'clearMessages'])]
    #[TestWith(['createRules', ['name' => 'required'], 'clearCreateRules'])]
    #[TestWith(['updateRules', ['name' => 'required'], 'clearUpdateRules'])]
    #[TestDox('$method is ok')]
    public function test_get_clear_property(string $property, array $value, string $method): void
    {
        $obj = $this->getMockObject($property, $value);
        $obj->$method();
        $this->assertSame([], (fn(): array => $obj->{$property})->call($obj));
    }

    #[TestWith(['rules', ['name' => 'required'], 'setRules'])]
    #[TestWith(['attributes', ['name' => 'required'], 'setAttributes'])]
    #[TestWith(['messages', ['name' => 'required'], 'setMessages'])]
    #[TestWith(['createRules', ['name' => 'required'], 'setCreateRules'])]
    #[TestWith(['updateRules', ['name' => 'required'], 'setUpdateRules'])]
    #[TestDox('$method is ok')]
    public function test_get_set_property(string $property, array $value, string $method): void
    {
        $obj = $this->getMockObject($property);
        $obj->$method($value);
        $this->assertSame($value, (fn(): array => $obj->{$property})->call($obj));
    }

    #[TestWith(['rules', ['name' => 'required'], 'addRule'])]
    #[TestWith(['attributes', ['name' => 'required'], 'addAttribute'])]
    #[TestWith(['messages', ['name' => 'required'], 'addMessage'])]
    #[TestWith(['createRules', ['name' => 'required'], 'addCreateRule'])]
    #[TestWith(['updateRules', ['name' => 'required'], 'addUpdateRule'])]
    #[TestDox('$method is ok')]
    public function test_get_add_item_to_property(string $property, array $value, string $method): void
    {
        $obj = $this->getMockObject($property, $value);
        $obj->$method('may_be', 'string');
        $this->assertSame($value + ['may_be' => 'string'], (fn(): array => $obj->{$property})->call($obj));
    }

    #[TestWith([['clearRules', 'clearAttributes', 'clearMessages', 'clearCreateRules', 'clearUpdateRules'], []])]
    #[TestWith([['setRules', 'setAttributes', 'setMessages', 'setCreateRules', 'setUpdateRules'], [[]]])]
    #[TestWith([['addRule', 'addAttribute', 'addMessage', 'addCreateRule', 'addUpdateRule'], ['p', 'v']])]
    public function test_clear_validator_instance(array $methods, array $params = []): void
    {
        foreach ($methods as $method) {
            $obj = $this->getMockObject(
                'validator',
                new Validator(new Translator(new ArrayLoader, 'en'), [], [])
            );
            $obj->{$method}(...$params);
            $this->assertFalse($obj->testIsValidatorInit());
        }
    }

    protected function getMockObject(?string $property = null, array|Validator|null $value = null): object
    {
        return new class($property, $value) extends MockModelValidator {
            public function __construct(?string $property = null, array|Validator|null $value = null)
            {
                parent::__construct(new MockModel);

                if ($property !== null && $value !== null) {
                    $this->{$property} = $value;
                }
            }

            public function testIsValidatorInit(): bool
            {
                return isset($this->validator);
            }
        };
    }
}