<?php

namespace YepBro\EloquentValidator\Tests\Feature\Rules\Strings;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestWith;
use YepBro\EloquentValidator\Exceptions\ModelValidatorNotFound;
use YepBro\EloquentValidator\Tests\Feature\FeatureTestCase;
use YepBro\EloquentValidator\Tests\Feature\Rules\RuleTestCase;

#[Group('Rules')]
#[Group('StringRules')]
class InRuleTest extends RuleTestCase
{
    use DatabaseMigrations;

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith(['toilet'])]
    public function test_validation_of_incorrect_data_with_a_stringable_rule(mixed $value)
    {
        $this->testException('in:foo,bar', $value, 'in');
    }

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith(['foo'])]
    public function test_validation_of_correct_data_with_a_stringable_rule(mixed $value)
    {
        $this->testSuccess('in:foo,bar', $value);
    }
}