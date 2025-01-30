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
class MaxRuleTest extends RuleTestCase
{
    use DatabaseMigrations;

    /**
     * @throws ModelValidatorNotFound
     */
    public function test_validation_of_incorrect_data_with_a_stringable_rule()
    {
        $this->testException('integer|max:2', 3, 'max.numeric');
    }

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith([1])]
    #[TestWith([19])]
    public function test_validation_of_correct_data_with_a_stringable_rule(int $value)
    {
        $this->testSuccess('integer|max:19', $value);
    }
}