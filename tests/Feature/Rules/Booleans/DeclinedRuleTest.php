<?php

namespace YepBro\EloquentValidator\Tests\Feature\Rules\Booleans;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestWith;
use YepBro\EloquentValidator\Exceptions\ModelValidatorNotFound;
use YepBro\EloquentValidator\Tests\Feature\FeatureTestCase;
use YepBro\EloquentValidator\Tests\Feature\Rules\RuleTestCase;

#[Group('Rules')]
#[Group('BooleanRules')]
class DeclinedRuleTest extends RuleTestCase
{
    use DatabaseMigrations;

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith([null])]
    #[TestWith([true])]
    #[TestWith([1])]
    public function test_validation_of_incorrect_data_with_a_stringable_rule(mixed $value): void
    {
        $this->testException('declined', $value);
    }

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith(['no'])]
    #[TestWith(['off'])]
    #[TestWith(['0'])]
    #[TestWith([0])]
    #[TestWith([false])]
    #[TestWith(['false'])]
    public function test_validation_of_correct_data_with_a_stringable_rule(mixed $value): void
    {
        $this->testSuccess('declined', $value);
    }
}