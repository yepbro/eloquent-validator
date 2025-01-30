<?php

namespace YepBro\EloquentValidator\Tests\Feature\Rules\Numbers;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use PHPUnit\Framework\Attributes\Group;
use YepBro\EloquentValidator\Exceptions\ModelValidatorNotFound;
use YepBro\EloquentValidator\Tests\Feature\FeatureTestCase;
use YepBro\EloquentValidator\Tests\Feature\Rules\RuleTestCase;

#[Group('Rules')]
#[Group('NumberRules')]
class DigitsRuleTest extends RuleTestCase
{
    use DatabaseMigrations;

    /** @throws ModelValidatorNotFound */
    public function test_validation_of_incorrect_data_with_a_stringable_rule()
    {
        $this->testException('digits:1', 100, 'digits');
    }

    /** @throws ModelValidatorNotFound */
    public function test_validation_of_correct_data_with_a_stringable_rule()
    {
        $this->testSuccess('digits:2', 99);
    }
}