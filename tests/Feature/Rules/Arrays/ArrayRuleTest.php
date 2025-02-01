<?php

namespace YepBro\EloquentValidator\Tests\Feature\Rules\Arrays;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestWith;
use YepBro\EloquentValidator\Exceptions\ModelValidatorNotFound;
use YepBro\EloquentValidator\Tests\Feature\Rules\RuleTestCase;

#[Group('Rules')]
#[Group('ArrayRules')]
class ArrayRuleTest extends RuleTestCase
{
    use DatabaseMigrations;

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith([null])]
    #[TestWith([true])]
    #[TestWith(['string'])]
    public function test_validation_of_incorrect_data_with_a_stringable_rule(mixed $value): void
    {
        $this->testException('array', $value);
    }

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith([[1, 'string']])]
    public function test_validation_of_correct_data_with_a_stringable_rule(mixed $value): void
    {
        $this->testSuccess('array', ['field' => $value]);
    }
}