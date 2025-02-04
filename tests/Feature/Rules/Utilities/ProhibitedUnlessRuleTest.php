<?php

namespace YepBro\EloquentValidator\Tests\Feature\Rules\Utilities;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestWith;
use YepBro\EloquentValidator\Exceptions\ModelValidatorNotFound;
use YepBro\EloquentValidator\Tests\Feature\FeatureTestCase;
use YepBro\EloquentValidator\Tests\Feature\Rules\RuleTestCase;

#[Group('Rules')]
#[Group('UtilityRules')]
class ProhibitedUnlessRuleTest extends RuleTestCase
{
    use DatabaseMigrations;

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith([false, 'foo_bar'])]
    #[TestWith([0, 'foo_bar'])]
    public function test_validation_of_incorrect_data_with_a_stringable_rule(mixed $value, mixed $other)
    {
        $this->testException('prohibited_unless:other,foo', [
            'field' => $value,
            'other' => $other,
        ], 'prohibited_unless');
    }

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith([null, 'foo_bar'])]
    #[TestWith(['', 'foo_bar'])]
    #[TestWith([[], 'foo_bar'])]
    #[TestWith(['go', 'foo'])]
    public function test_validation_of_correct_data_with_a_stringable_rule(mixed $value, mixed $other)
    {
        $this->testSuccess('prohibited_unless:other,foo', [
            'field' => $value,
            'other' => $other,
        ]);
    }
}