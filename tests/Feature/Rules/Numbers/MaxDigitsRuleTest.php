<?php

namespace YepBro\EloquentValidator\Tests\Feature\Rules\Numbers;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestWith;
use YepBro\EloquentValidator\Exceptions\ModelValidatorNotFound;
use YepBro\EloquentValidator\Tests\Feature\FeatureTestCase;
use YepBro\EloquentValidator\Tests\Feature\Rules\RuleTestCase;

#[Group('Rules')]
#[Group('NumberRules')]
class MaxDigitsRuleTest extends RuleTestCase
{
    use DatabaseMigrations;

    /**
     * @throws ModelValidatorNotFound
     */
    public function test_validation_of_incorrect_data_with_a_stringable_rule()
    {
        $this->testException('max_digits:2', 100, 'max_digits');
    }

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith([1])]
    #[TestWith([99])]
    public function test_validation_of_correct_data_with_a_stringable_rule(int $value)
    {
        $this->testSuccess('max_digits:2', $value);
    }
}