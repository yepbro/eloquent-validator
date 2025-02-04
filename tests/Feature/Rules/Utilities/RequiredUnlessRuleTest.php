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
class RequiredUnlessRuleTest extends RuleTestCase
{
    use DatabaseMigrations;

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith([null, 'bar'])]
    #[TestWith([[], 'bar'])]
    public function test_validation_of_incorrect_data_with_a_stringable_rule(mixed $value, mixed $other)
    {
        $this->testException('required_unless:other,foo', [
            'field' => $value,
            'other' => $other,
        ], 'required_unless');
    }

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith(['null', 'foo'])]
    #[TestWith([[0], 'foo'])]
    #[TestWith([null, 'foo'])]
    #[TestWith(['s', 'bar'])]
    public function test_validation_of_correct_data_with_a_stringable_rule(mixed $value, mixed $other)
    {
        $this->testSuccess('required_unless:other,foo', [
            'field' => $value,
            'other' => $other,
        ]);
    }
}