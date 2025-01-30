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
class AcceptedIfRuleTest extends RuleTestCase
{
    use DatabaseMigrations;

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith([null])]
    #[TestWith(['string'])]
    public function test_validation_of_incorrect_data_with_a_stringable_rule(mixed $value): void
    {
        $this->testException("accepted_if:other,php", [
            'field' => $value,
            'other' => 'php',
        ], 'accepted_if');
    }

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith(['yes'])]
    #[TestWith(['on'])]
    #[TestWith(['1'])]
    #[TestWith([1])]
    #[TestWith([true])]
    #[TestWith(['true'])]
    #[TestWith([true, 'perl'])]
    #[TestWith([false, 'perl'])]
    public function test_validation_of_correct_data_with_a_stringable_rule(mixed $value, mixed $other = 'php'): void
    {
        $this->testSuccess("accepted_if:other,php", [
            'field' => $value,
            'other' => $other,
        ]);
    }
}