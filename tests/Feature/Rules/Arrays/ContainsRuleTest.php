<?php

namespace YepBro\EloquentValidator\Tests\Feature\Rules\Arrays;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestWith;
use YepBro\EloquentValidator\Exceptions\ModelValidatorNotFound;
use YepBro\EloquentValidator\Tests\Feature\Rules\RuleTestCase;

#[Group('Rules')]
#[Group('ArrayRules')]
class ContainsRuleTest extends RuleTestCase
{
    use DatabaseMigrations;

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith([['foo', 'error']])]
    #[TestWith([['bar']])]
    #[TestWith([['error']])]
    public function test_validation_of_incorrect_data_with_a_stringable_rule(mixed $value): void
    {
        $this->testException('contains:foo,bar', ['field' => $value], 'contains');
    }

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith([['foo', 'bar']])]
    #[TestWith([['foo', 'bar', 'baz']])]
    public function test_validation_of_correct_data_with_a_stringable_rule(mixed $value): void
    {
        $this->testSuccess('contains:foo,bar', ['field' => $value]);
    }
}