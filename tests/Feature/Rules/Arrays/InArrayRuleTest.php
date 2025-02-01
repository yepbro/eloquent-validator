<?php

namespace YepBro\EloquentValidator\Tests\Feature\Rules\Arrays;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestWith;
use YepBro\EloquentValidator\Exceptions\ModelValidatorNotFound;
use YepBro\EloquentValidator\Tests\Feature\Rules\RuleTestCase;

#[Group('Rules')]
#[Group('BooleanRules')]
class InArrayRuleTest extends RuleTestCase
{
    use DatabaseMigrations;

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith([1, [3, 5]])]
    #[TestWith(['text', [3, 'text2']])]
    public function test_validation_of_incorrect_data_with_a_stringable_rule(mixed $value, array $other): void
    {
        $this->testException('in_array:other.*', ['field' => $value, 'other' => $other], 'in_array');
    }

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith([1, [3, 5, 1]])]
    #[TestWith(['text', [3, 'text2', 'text']])]
    public function test_validation_of_correct_data_with_a_stringable_rule(mixed $value, array $other): void
    {
        $this->testSuccess('in_array:other.*', ['field' => $value, 'other' => $other]);
    }
}