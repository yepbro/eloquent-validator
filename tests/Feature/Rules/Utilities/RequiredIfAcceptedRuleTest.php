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
class RequiredIfAcceptedRuleTest extends RuleTestCase
{
    use DatabaseMigrations;

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith([null, 'yes'])]
    #[TestWith(['', '1'])]
    #[TestWith([[], 'on'])]
    public function test_validation_of_incorrect_data_with_a_stringable_rule(mixed $value, mixed $other)
    {
        $this->testException('required_if_accepted:other', [
            'field' => $value,
            'other' => $other,
        ], 'required_if_accepted');
    }

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith(['ten', 'yes'])]
    #[TestWith([false, 'on'])]
    public function test_validation_of_correct_data_with_a_stringable_rule(mixed $value, mixed $other)
    {
        $this->testSuccess('required_if_accepted:other', [
            'field' => $value,
            'other' => $other,
        ]);
    }
}