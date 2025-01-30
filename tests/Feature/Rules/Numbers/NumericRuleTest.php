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
class NumericRuleTest extends RuleTestCase
{
    use DatabaseMigrations;

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith(['0x539'])]
    #[TestWith(['0b10100111001'])]
    #[TestWith([true])]
    public function test_validation_of_incorrect_data_with_a_stringable_rule(mixed $value)
    {
        $this->testException('numeric', $value);
    }

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith([1])]
    #[TestWith(['42'])]
    #[TestWith([1.1])]
    #[TestWith([-1.1])]
    public function test_validation_of_correct_data_with_a_stringable_rule(int|float|string $value)
    {
        $this->testSuccess('numeric', $value);
    }
}