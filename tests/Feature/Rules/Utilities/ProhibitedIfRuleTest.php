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
class ProhibitedIfRuleTest extends RuleTestCase
{
    use DatabaseMigrations;

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith([false, 'foo'])]
    #[TestWith([0, 'foo'])]
    public function test_validation_of_incorrect_data_with_a_stringable_rule(mixed $value, mixed $other)
    {
        $this->testException('prohibited_if:other,foo', [
            'field' => $value,
            'other' => $other,
        ], 'prohibited_if');
    }

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith([null, 'foo'])]
    #[TestWith(['', 'foo'])]
    #[TestWith([[], 'foo'])]
    #[TestWith(['go', 'foo_bar'])]
    public function test_validation_of_correct_data_with_a_stringable_rule(mixed $value, mixed $other)
    {
        $this->testSuccess('prohibited_if:other,foo', [
            'field' => $value,
            'other' => $other,
        ]);
    }
}