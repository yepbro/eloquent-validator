<?php

namespace YepBro\EloquentValidator\Tests\Feature\Rules\Arrays;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestWith;
use YepBro\EloquentValidator\Exceptions\ModelValidatorNotFound;
use YepBro\EloquentValidator\Tests\Feature\Rules\RuleTestCase;

#[Group('Rules')]
#[Group('ArrayRules')]
class ListRuleTest extends RuleTestCase
{
    use DatabaseMigrations;

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith([[0 => 0, 2 => 1, 3 => 2]])]
    #[TestWith([[0 => 0, 2 => 2, 1 => 1]])]
    #[TestWith([[0 => 0, 1 => 2, 3 => 1]])]
    public function test_validation_of_incorrect_data_with_a_stringable_rule(mixed $value): void
    {
        $this->testException('list', ['field' => $value], 'list');
    }

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith([[1, 'two', '3']])]
    #[TestWith([[0 => 0, 1 => 1, 2 => 2]])]
    #[TestWith([[0 => 0, 1 => 1, '2' => 2]])]
    public function test_validation_of_correct_data_with_a_stringable_rule(mixed $value): void
    {
        $this->testSuccess('list', ['field' => $value]);
    }
}