<?php

namespace YepBro\EloquentValidator\Tests\Feature\Rules\Numbers;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use PHPUnit\Framework\Attributes\Group;
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
    public function test_validation_of_incorrect_data_with_a_stringable_rule()
    {
        $this->testException('gt:other', [
            'other' => 5,
            'field' => 5,
        ], 'gt.numeric');
    }

    /**
     * @throws ModelValidatorNotFound
     */
    public function test_validation_of_correct_data_with_a_stringable_rule()
    {
        $this->testSuccess('gt:other', [
            'other' => 5,
            'field' => 6,
        ]);
    }
}