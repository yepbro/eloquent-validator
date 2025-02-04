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
class RequiredIfRuleTest extends RuleTestCase
{
    use DatabaseMigrations;

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith([null, 'foo'])]
    #[TestWith(['', 'foo'])]
    #[TestWith([[], 'foo'])]
    public function test_validation_of_incorrect_data_with_a_stringable_rule(mixed $value, mixed $other)
    {
        $this->testException('required_if:other,foo', [
            'field' => $value,
            'other' => $other,
        ], 'required_if');
    }

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith([0, 'foo'])]
    #[TestWith([null, 'foo_bar'])]
    public function test_validation_of_correct_data_with_a_stringable_rule(mixed $value, mixed $other)
    {
        $this->testSuccess('required_if:other,foo', [
            'field' => $value,
            'other' => $other,
        ]);
    }
}