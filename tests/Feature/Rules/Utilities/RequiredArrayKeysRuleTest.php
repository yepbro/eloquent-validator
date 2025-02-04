<?php

namespace YepBro\EloquentValidator\Tests\Feature\Rules\Utilities;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestWith;
use YepBro\EloquentValidator\Exceptions\ModelValidatorNotFound;
use YepBro\EloquentValidator\Tests\Feature\FeatureTestCase;
use YepBro\EloquentValidator\Tests\Feature\Rules\RuleTestCase;

#[Group('Rules')]
#[Group('UtilityRules')]
class RequiredArrayKeysRuleTest extends RuleTestCase
{
    use DatabaseMigrations;

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith([null, 'no'])]
    #[TestWith([['k' => 1, 'm' => 2], 'z'])]
    #[TestWith([['k' => 1, 'm' => 2], 'k,z,m'])]
    public function test_validation_of_incorrect_data_with_a_stringable_rule(mixed $value, mixed $keys)
    {
        $this->testException("required_array_keys:$keys", [
            'field' => $value,
        ], 'required_array_keys');
    }

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith([['k' => 1, 'm' => 2], 'k'])]
    #[TestWith([['k' => 1, 'm' => 2], 'm,k'])]
    public function test_validation_of_correct_data_with_a_stringable_rule(mixed $value, mixed $keys)
    {
        $this->testSuccess("required_array_keys:$keys", [
            'field' => $value,
        ]);
    }
}