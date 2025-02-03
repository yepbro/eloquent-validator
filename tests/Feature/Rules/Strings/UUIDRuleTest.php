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
class UUIDRuleTest extends RuleTestCase
{
    use DatabaseMigrations;

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith(['01ARZ3NDEKTSV4RRFFQ69G5FAV'])]
    public function test_validation_of_incorrect_data_with_a_stringable_rule(mixed $value)
    {
        $this->testException('uuid', $value);
    }

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith(['1e4f8b9c-5a6d-11ee-b962-0242ac120002'])]
    #[TestWith(['3f8b9c5a-6d1e-3ee5-b962-0242ac120002'])]
    #[TestWith(['5a6d1e4f-8b9c-4ee5-b962-0242ac120002'])]
    #[TestWith(['6d1e4f8b-9c5a-5ee5-b962-0242ac120002'])]
    #[TestWith(['1e4f8b9c-5a6d-61ee-b962-0242ac120002'])]
    #[TestWith(['018b9c5a-6d1e-7ee5-b962-0242ac120002'])]
    #[TestWith(['8b9c5a6d-1e4f-8ee5-b962-0242ac120002'])]
    public function test_validation_of_correct_data_with_a_stringable_rule(mixed $value)
    {
        $this->testSuccess('uuid', $value);
    }
}