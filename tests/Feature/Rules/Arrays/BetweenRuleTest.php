<?php

namespace YepBro\EloquentValidator\Tests\Feature\Rules\Arrays;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestWith;
use YepBro\EloquentValidator\Exceptions\ModelValidatorNotFound;
use YepBro\EloquentValidator\Tests\Feature\FeatureTestCase;
use YepBro\EloquentValidator\Tests\Feature\Rules\RuleTestCase;

#[Group('Rules')]
#[Group('ArrayRules')]
class BetweenRuleTest extends RuleTestCase
{
    use DatabaseMigrations;

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith([[1]])]
    #[TestWith([[1, 2, 3, 4, 5]])]
    public function test_validation_of_incorrect_data_with_a_stringable_rule(mixed $value): void
    {
        $this->testException('array|between:2,4', ['field' => $value], 'between.array');
    }

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith([[1, 2]])]
    #[TestWith([[1, 2, 3]])]
    public function test_validation_of_correct_data_with_a_stringable_rule(mixed $value): void
    {
        $this->testSuccess('array|between:2,4', ['field' => $value]);
    }
}