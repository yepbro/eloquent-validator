<?php

namespace YepBro\EloquentValidator\Tests\Feature\Rules\Dates;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestWith;
use YepBro\EloquentValidator\Exceptions\ModelValidatorNotFound;
use YepBro\EloquentValidator\Tests\Feature\FeatureTestCase;
use YepBro\EloquentValidator\Tests\Feature\Rules\RuleTestCase;

#[Group('Rules')]
#[Group('DateRules')]
class DateEqualsRuleTest extends RuleTestCase
{
    use DatabaseMigrations;

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith(['2024-12-22'])]
    public function test_validation_of_incorrect_data_with_a_stringable_rule(mixed $value)
    {
        $this->testException('date_equals:2024-12-12', $value, 'date_equals');
    }

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith(['10 September 2000'])]
    #[TestWith(['2000-09-10'])]
    #[TestWith(['10.09.2000'])]
    public function test_validation_of_correct_data_with_a_stringable_rule(mixed $value)
    {
        $this->testSuccess('date_equals:2000-09-10', $value);
    }
}