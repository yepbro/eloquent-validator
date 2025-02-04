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
class ProhibitsRuleTest extends RuleTestCase
{
    use DatabaseMigrations;

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith(['one', 'one'])]
    #[TestWith([false, false])]
    public function test_validation_of_incorrect_data_with_a_stringable_rule(mixed $value, mixed $other)
    {
        $this->testException('prohibits:other', [
            'field' => $value,
            'other' => $other,
        ], 'prohibits');
    }

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith(['null', []])]
    #[TestWith(['x', null])]
    #[TestWith([[5], ''])]
    #[TestWith([null, ''])]
    public function test_validation_of_correct_data_with_a_stringable_rule(mixed $value, mixed $other)
    {
        $this->testSuccess('prohibits:other', [
            'field' => $value,
            'other' => $other,
        ]);
    }
}