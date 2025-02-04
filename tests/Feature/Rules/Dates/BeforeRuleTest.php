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
class BeforeRuleTest extends RuleTestCase
{
    use DatabaseMigrations;

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith(['2024-12-22'])]
    #[TestWith(['2024-12-12'])]
    public function test_validation_of_incorrect_data_with_a_stringable_rule(mixed $value)
    {
        $this->testException('before:2024-12-12', $value, 'before');
    }

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith(['10 September 1999'])]
    #[TestWith(['2000-09-09'])]
    #[TestWith(['01.09.2000'])]
    public function test_validation_of_correct_data_with_a_stringable_rule(mixed $value)
    {
        $this->testSuccess('before:2000-09-10', $value);
    }
}