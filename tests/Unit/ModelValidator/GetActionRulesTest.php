<?php
declare(strict_types=1);

namespace YepBro\EloquentValidator\Tests\Unit\ModelValidator;

use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\Group;
use YepBro\EloquentValidator\ActionEnum;
use YepBro\EloquentValidator\ModelValidator;
use YepBro\EloquentValidator\Tests\Unit\Mocks\MockModel;
use YepBro\EloquentValidator\Tests\Unit\Mocks\MockModelValidator;
use YepBro\EloquentValidator\Tests\Unit\UnitTestCase;

#[CoversMethod(ModelValidator::class, 'getActionRules')]
#[Group('ModelValidator')]
class GetActionRulesTest extends UnitTestCase
{
    public function test_if_only_base_rules_set(): void
    {
        $obj = $this->getMockObject();
        $this->assertSame($this->rules, $obj->magicCallMethod('getActionRules'));
    }

    public function test_get_update_rules_by_enum(): void
    {
        $obj = $this->getMockObject('updateRules', ['second' => 'required']);
        $this->assertSame($this->rules + ['second' => 'required'], $obj->magicCallMethod('getActionRules', ActionEnum::UPDATE));
    }

    public function test_get_update_rules_by_model(): void
    {
        $this->markTestSkipped();
    }

    public function test_get_create_rules_by_enum(): void
    {
        $obj = $this->getMockObject('createRules', ['second' => 'required']);
        $this->assertSame($this->rules + ['second' => 'required'], $obj->magicCallMethod('getActionRules', ActionEnum::CREATE));
    }

    public function test_get_create_rules_by_model(): void
    {
        $this->markTestSkipped();
    }

    public function test_get_update_rules_and_removed_empty_keys(): void
    {
        $obj = $this->getMockObject('updateRules', ['second' => 'required', 'age' => null]);
        $this->assertSame(['name' => 'required', 'second' => 'required'], $obj->magicCallMethod('getActionRules', ActionEnum::UPDATE));
    }

    public function test_get_create_rules_and_removed_empty_keys(): void
    {
        $obj = $this->getMockObject('createRules', ['second' => 'required', 'age' => null]);
        $this->assertSame(['name' => 'required', 'second' => 'required'], $obj->magicCallMethod('getActionRules', ActionEnum::CREATE));
    }

    protected array $rules = ['name' => 'required', 'age' => 'required'];

    protected function getMockObject(?string $property = null, ?array $value = null): object
    {
        return new class($property, $value) extends MockModelValidator {
            protected array $rules = ['name' => 'required', 'age' => 'required'];
            protected array $updateRules = [];
            protected array $createRules = [];

            public function __construct(?string $property = null, ?array $value = null)
            {
                parent::__construct(new MockModel);
                if ($property !== null && $value !== null) {
                    $this->magicSetProperty($property, $value);
                }
            }
        };
    }
}