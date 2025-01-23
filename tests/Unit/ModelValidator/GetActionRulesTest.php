<?php
declare(strict_types=1);

namespace YepBro\EloquentValidator\Tests\Unit\ModelValidator;

use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\Group;
use YepBro\EloquentValidator\ActionEnum;
use YepBro\EloquentValidator\ModelValidator;
use YepBro\EloquentValidator\Tests\Unit\UnitTestCase;

#[CoversMethod(ModelValidator::class, 'getActionRules')]
#[Group('ModelValidator')]
class GetActionRulesTest extends UnitTestCase
{
    public function test_if_only_base_rules_set(): void
    {
        $validator = $this->getMockModelValidator([], ['rules' => $this->rules]);
        $this->assertSame($this->rules, $validator->magicCallMethod('getActionRules'));
    }

    public function test_get_update_rules_by_enum(): void
    {
        $validator = $this->getMockModelValidator([], ['rules' => $this->rules, 'updateRules' => ['second' => 'required']]);
        $this->assertSame($this->rules + ['second' => 'required'], $validator->magicCallMethod('getActionRules', ActionEnum::UPDATE));
    }

    public function test_get_update_rules_by_model(): void
    {
        $this->markTestSkipped();
    }

    public function test_get_create_rules_by_enum(): void
    {
        $validator = $this->getMockModelValidator([], ['rules' => $this->rules, 'createRules' => ['second' => 'required']]);
        $this->assertSame($this->rules + ['second' => 'required'], $validator->magicCallMethod('getActionRules', ActionEnum::CREATE));
    }

    public function test_get_create_rules_by_model(): void
    {
        $this->markTestSkipped();
    }

    public function test_get_update_rules_and_removed_empty_keys(): void
    {
        $validator = $this->getMockModelValidator([], ['rules' => $this->rules, 'updateRules' => ['second' => 'required', 'age' => null]]);
        $this->assertSame(['name' => 'required', 'second' => 'required'], $validator->magicCallMethod('getActionRules', ActionEnum::UPDATE));
    }

    public function test_get_create_rules_and_removed_empty_keys(): void
    {
        $validator = $this->getMockModelValidator([], ['rules' => $this->rules, 'createRules' => ['second' => 'required', 'age' => null]]);
        $this->assertSame(['name' => 'required', 'second' => 'required'], $validator->magicCallMethod('getActionRules', ActionEnum::CREATE));
    }

    protected array $rules = ['name' => 'required', 'age' => 'required'];
}