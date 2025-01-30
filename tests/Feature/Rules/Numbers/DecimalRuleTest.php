<?php

namespace YepBro\EloquentValidator\Tests\Feature\Rules\Numbers;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use PHPUnit\Framework\Attributes\Group;
use YepBro\EloquentValidator\Exceptions\ModelValidatorNotFound;
use YepBro\EloquentValidator\Tests\Feature\FeatureTestCase;
use YepBro\EloquentValidator\Tests\Feature\Rules\RuleTestCase;

#[Group('Rules')]
#[Group('NumberRules')]
class DecimalRuleTest extends RuleTestCase
{
    use DatabaseMigrations;

    /**
     * @throws ModelValidatorNotFound
     */
    public function test_validation_of_incorrect_data_with_a_stringable_rule()
    {
        $this->testException('decimal:2,4', 5.55555, 'decimal');
    }

    /**
     * @throws ModelValidatorNotFound
     */
    public function test_validation_of_correct_data_with_a_stringable_rule()
    {
        $this->testSuccess('decimal:2,4', 5.22);
    }
}