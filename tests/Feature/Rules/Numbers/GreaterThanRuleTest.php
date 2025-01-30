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
class GreaterThanRuleTest extends RuleTestCase
{
    use DatabaseMigrations;

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith([6, 7])]
    #[TestWith([5, 5])]
    public function test_validation_of_incorrect_data_with_a_stringable_rule(int $field, int $other)
    {
        $this->testException('gt:other', array(
            'other' => $other,
            'field' => $field,
        ), 'gt.numeric');
    }

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith([6, 5])]
    public function test_validation_of_correct_data_with_a_stringable_rule(int $field, int $other)
    {
        $this->testSuccess('gt:other', [
            'other' => $other,
            'field' => $field,
        ]);
    }
}