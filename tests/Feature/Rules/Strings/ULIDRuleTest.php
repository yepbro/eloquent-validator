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
class ULIDRuleTest extends RuleTestCase
{
    use DatabaseMigrations;

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith(['01ARZ3NDEKTSV4RRFFQ69G5FAV1'])]
    public function test_validation_of_incorrect_data_with_a_stringable_rule(mixed $value)
    {
        $this->testException('ulid', $value);
    }

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith(['01ARZ3NDEKTSV4RRFFQ69G5FAV'])]
    public function test_validation_of_correct_data_with_a_stringable_rule(mixed $value)
    {
        $this->testSuccess('ulid', $value);
    }
}