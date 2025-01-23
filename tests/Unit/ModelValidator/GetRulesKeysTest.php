<?php
declare(strict_types=1);

namespace YepBro\EloquentValidator\Tests\Unit\ModelValidator;

use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\Group;
use YepBro\EloquentValidator\ActionEnum;
use YepBro\EloquentValidator\ModelValidator;
use YepBro\EloquentValidator\Tests\Unit\UnitTestCase;

#[CoversMethod(ModelValidator::class, 'getUsedRulesKeys')]
#[Group('ModelValidator')]
class GetRulesKeysTest extends UnitTestCase
{
    public function test_if_only_base_rules_set(): void
    {
        $validator = $this->getMockModelValidator([], ['rules' => $this->rules]);
        $this->assertSame(array_keys($this->rules), $validator->magicCallMethod('getUsedRulesKeys'));
    }

    public function test_get_update_rules_by_enum(): void
    {
        $validator = $this->getMockModelValidator([], ['rules' => $this->rules, 'updateRules' => ['second' => 'required']]);
        $this->assertSame($this->keys, $validator->magicCallMethod('getUsedRulesKeys', ActionEnum::UPDATE));
    }

    public function test_get_update_rules_by_model(): void
    {
        $validator = $this->getMockModelValidator(['exists' => true], ['rules' => $this->rules, 'updateRules' => ['second' => 'required']]);
        $this->assertSame($this->keys, $validator->magicCallMethod('getUsedRulesKeys'));
    }

    public function test_get_create_rules_by_enum(): void
    {
        $validator = $this->getMockModelValidator([], ['rules' => $this->rules, 'createRules' => ['second' => 'required']]);
        $this->assertSame($this->keys, $validator->magicCallMethod('getUsedRulesKeys', ActionEnum::CREATE));
    }

    public function test_get_create_rules_by_model(): void
    {
        $validator = $this->getMockModelValidator(['exists' => false], ['rules' => $this->rules, 'createRules' => ['second' => 'required']]);
        $this->assertSame($this->keys, $validator->magicCallMethod('getUsedRulesKeys'));
    }

    public function test_get_update_rules_and_removed_empty_keys(): void
    {
        $validator = $this->getMockModelValidator([], ['rules' => $this->rules, 'updateRules' => ['second' => 'required', 'age' => null]]);
        $this->assertSame($this->filteredKeys, $validator->magicCallMethod('getUsedRulesKeys', ActionEnum::UPDATE));
    }

    public function test_get_create_rules_and_removed_empty_keys(): void
    {
        $validator = $this->getMockModelValidator([], ['rules' => $this->rules, 'createRules' => ['second' => 'required', 'age' => null]]);
        $this->assertSame($this->filteredKeys, $validator->magicCallMethod('getUsedRulesKeys', ActionEnum::CREATE));
    }

    protected array $rules = ['name' => 'required', 'age' => 'required'];
    protected array $keys = ['name', 'age', 'second'];
    protected array $filteredKeys = ['name', 'second'];
}