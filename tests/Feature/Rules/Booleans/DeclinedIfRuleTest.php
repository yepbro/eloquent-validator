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
class DeclinedIfRuleTest extends RuleTestCase
{
    use DatabaseMigrations;

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith([null])]
    #[TestWith(['string'])]
    public function test_validation_of_incorrect_data_with_a_stringable_rule(mixed $value): void
    {
        $this->testException("declined_if:other,php", [
            'field' => $value,
            'other' => 'php',
        ], 'declined_if');
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
    #[TestWith([false, 'perl'])]
    #[TestWith([true, 'perl'])]
    public function test_validation_of_correct_data_with_a_stringable_rule(mixed $value, mixed $other = 'php'): void
    {
        $this->testSuccess("declined_if:other,php", [
            'field' => $value,
            'other' => $other,
        ]);
    }
}