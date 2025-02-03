<?php

namespace YepBro\EloquentValidator\Tests\Feature\Rules\Strings;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestWith;
use YepBro\EloquentValidator\Exceptions\ModelValidatorNotFound;
use YepBro\EloquentValidator\Tests\Feature\FeatureTestCase;
use YepBro\EloquentValidator\Tests\Feature\Rules\RuleTestCase;

#[Group('Rules')]
#[Group('StringRules')]
class MaxRuleTest extends RuleTestCase
{
    use DatabaseMigrations;

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith(['eleven'])]
    public function test_validation_of_incorrect_data_with_a_stringable_rule(mixed $value)
    {
        $this->testException('max:4', $value, 'max.string');
    }

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith(['four'])]
    #[TestWith(['two'])]
    public function test_validation_of_correct_data_with_a_stringable_rule(mixed $value)
    {
        $this->testSuccess('max:4', $value);
    }
}