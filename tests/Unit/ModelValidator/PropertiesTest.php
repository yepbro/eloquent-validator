<?php
declare(strict_types=1);

namespace YepBro\EloquentValidator\Tests\Unit\ModelValidator;

use Illuminate\Translation\ArrayLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Validator;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\TestWith;
use YepBro\EloquentValidator\ModelValidator;
use YepBro\EloquentValidator\Tests\Unit\UnitTestCase;

#[CoversMethod(ModelValidator::class, 'getRules')]
#[CoversMethod(ModelValidator::class, 'getAttributes')]
#[CoversMethod(ModelValidator::class, 'getMessages')]
#[CoversMethod(ModelValidator::class, 'getCreateRules')]
#[CoversMethod(ModelValidator::class, 'getUpdateRules')]
#[CoversMethod(ModelValidator::class, 'getData')]
#[CoversMethod(ModelValidator::class, 'clearRules')]
#[CoversMethod(ModelValidator::class, 'clearAttributes')]
#[CoversMethod(ModelValidator::class, 'clearMessages')]
#[CoversMethod(ModelValidator::class, 'clearCreateRules')]
#[CoversMethod(ModelValidator::class, 'clearUpdateRules')]
#[CoversMethod(ModelValidator::class, 'clearData')]
#[CoversMethod(ModelValidator::class, 'setRules')]
#[CoversMethod(ModelValidator::class, 'setAttributes')]
#[CoversMethod(ModelValidator::class, 'setMessages')]
#[CoversMethod(ModelValidator::class, 'setCreateRules')]
#[CoversMethod(ModelValidator::class, 'setUpdateRules')]
#[CoversMethod(ModelValidator::class, 'setData')]
#[CoversMethod(ModelValidator::class, 'addRule')]
#[CoversMethod(ModelValidator::class, 'addAttribute')]
#[CoversMethod(ModelValidator::class, 'addMessage')]
#[CoversMethod(ModelValidator::class, 'addCreateRule')]
#[CoversMethod(ModelValidator::class, 'addUpdateRule')]
#[CoversMethod(ModelValidator::class, 'addData')]
#[Group('ModelValidator')]
class PropertiesTest extends UnitTestCase
{
    #[TestWith(['rules', ['name' => 'required'], 'getRules'])]
    #[TestWith(['attributes', ['name' => 'required'], 'getAttributes'])]
    #[TestWith(['messages', ['name' => 'required'], 'getMessages'])]
    #[TestWith(['createRules', ['name' => 'required'], 'getCreateRules'])]
    #[TestWith(['updateRules', ['name' => 'required'], 'getUpdateRules'])]
    #[TestWith(['modelData', ['name' => 'required'], 'getData'])]
    #[TestDox('$method is ok')]
    public function test_get_property(string $property, array $value, string $method): void
    {
        $validator = $this->getMockModelValidator([], [$property => $value]);
        $this->assertSame($value, $validator->$method());
    }

    #[TestWith(['rules', ['name' => 'required'], 'clearRules'])]
    #[TestWith(['attributes', ['name' => 'required'], 'clearAttributes'])]
    #[TestWith(['messages', ['name' => 'required'], 'clearMessages'])]
    #[TestWith(['createRules', ['name' => 'required'], 'clearCreateRules'])]
    #[TestWith(['updateRules', ['name' => 'required'], 'clearUpdateRules'])]
    #[TestWith(['modelData', ['name' => 'required'], 'clearData'])]
    #[TestDox('$method is ok')]
    public function test_get_clear_property(string $property, array $value, string $method): void
    {
        $validator = $this->getMockModelValidator([], [$property => $value]);
        $validator->$method();
        $this->assertSame([], (fn(): array => $validator->{$property})->call($validator));
    }

    #[TestWith(['rules', ['name' => 'required'], 'setRules'])]
    #[TestWith(['attributes', ['name' => 'required'], 'setAttributes'])]
    #[TestWith(['messages', ['name' => 'required'], 'setMessages'])]
    #[TestWith(['createRules', ['name' => 'required'], 'setCreateRules'])]
    #[TestWith(['updateRules', ['name' => 'required'], 'setUpdateRules'])]
    #[TestWith(['modelData', ['name' => 'required'], 'setData'])]
    #[TestDox('$method is ok')]
    public function test_get_set_property(string $property, array $value, string $method): void
    {
        $validator = $this->getMockModelValidator([], [$property => $value]);
        $validator->$method($value);
        $this->assertSame($value, (fn(): array => $validator->{$property})->call($validator));
    }

    #[TestWith(['rules', 'addRule'])]
    #[TestWith(['createRules', 'addCreateRule'])]
    #[TestWith(['updateRules', 'addUpdateRule'])]
    #[TestDox('$method is ok')]
    public function test_get_add_array_item_to_rules_property(string $property, string $method): void
    {
        $value = ['name' => 'required'];
        $validator = $this->getMockModelValidator([], [$property => $value]);
        $validator->$method('may_be', ['string']);
        $expected = $value + ['may_be' => ['string']];
        $this->assertSame($expected, (fn(): array => $validator->{$property})->call($validator));
    }

    #[TestWith(['rules', 'addRule'])]
    #[TestWith(['createRules', 'addCreateRule'])]
    #[TestWith(['updateRules', 'addUpdateRule'])]
    #[TestDox('$method is ok')]
    public function test_get_add_string_item_to_rules_property(string $property, string $method): void
    {
        $value = ['name' => 'required'];
        $validator = $this->getMockModelValidator([], [$property => $value]);
        $validator->$method('may_be', 'string');
        $expected = $value + ['may_be' => ['string']];
        $this->assertSame($expected, (fn(): array => $validator->{$property})->call($validator));
    }

    #[TestWith(['attributes', 'addAttribute'])]
    #[TestWith(['messages', 'addMessage'])]
    #[TestWith(['modelData', 'addData'])]
    #[TestDox('$method is ok')]
    public function test_get_add_item_to_property(string $property, string $method): void
    {
        $value = ['name' => 'description'];
        $validator = $this->getMockModelValidator([], [$property => $value]);
        $validator->$method('may_be', 'string');
        $expected = $value + ['may_be' => 'string'];
        $this->assertSame($expected, (fn(): array => $validator->{$property})->call($validator));
    }

    #[TestWith([['clearRules', 'clearAttributes', 'clearMessages', 'clearCreateRules', 'clearUpdateRules', 'clearData'], []])]
    #[TestWith([['setRules', 'setAttributes', 'setMessages', 'setCreateRules', 'setUpdateRules', 'setData'], [[]]])]
    #[TestWith([['addRule', 'addAttribute', 'addMessage', 'addCreateRule', 'addUpdateRule', 'addData'], ['p', 'v']])]
    public function test_clear_validator_instance(array $methods, array $params = []): void
    {
        foreach ($methods as $method) {
            $laravelValidator = new Validator(new Translator(new ArrayLoader, 'en'), [], []);
            $validator = $this->getMockModelValidator([], ['validator' => $laravelValidator]);
            $validator->{$method}(...$params);
            $this->assertFalse($validator->testIsValidatorInit());
        }
    }
}