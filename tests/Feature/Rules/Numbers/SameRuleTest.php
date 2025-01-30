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
class SameRuleTest extends RuleTestCase
{
    use DatabaseMigrations;

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith(['1'])]
    #[TestWith([1.0])]
    #[TestWith([true])]
    public function test_validation_of_incorrect_data_with_a_stringable_rule(mixed $value)
    {
        $this->testException('same:other', [
            'field' => 1,
            'other' => $value,
        ], 'same');
    }

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith([1])]
    public function test_validation_of_correct_data_with_a_stringable_rule(int $value)
    {
        $this->testSuccess('same:other', [
            'field' => 1,
            'other' => $value,
        ]);
    }
}