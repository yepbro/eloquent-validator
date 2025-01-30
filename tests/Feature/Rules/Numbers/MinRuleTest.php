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
class MinRuleTest extends RuleTestCase
{
    use DatabaseMigrations;

    /**
     * @throws ModelValidatorNotFound
     */
    public function test_validation_of_incorrect_data_with_a_stringable_rule()
    {
        $this->testException('integer|min:2', 1, 'min.numeric');
    }

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith([20])]
    #[TestWith([19])]
    public function test_validation_of_correct_data_with_a_stringable_rule(int $value)
    {
        $this->testSuccess('integer|min:19', $value);
    }
}