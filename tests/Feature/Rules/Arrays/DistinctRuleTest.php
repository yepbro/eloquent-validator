<?php

namespace YepBro\EloquentValidator\Tests\Feature\Rules\Arrays;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use PHPUnit\Framework\Attributes\Group;
use YepBro\EloquentValidator\Tests\Feature\Rules\RuleTestCase;

#[Group('Rules')]
#[Group('ArrayRules')]
class DistinctRuleTest extends RuleTestCase
{
    use DatabaseMigrations;

    public function test_validation_of_incorrect_data_with_a_stringable_rule(): void
    {
        $this->markTestSkipped('The validation rule is not applicable to models.');
    }

    public function test_validation_of_correct_data_with_a_stringable_rule(): void
    {
        $this->markTestSkipped('The validation rule is not applicable to models.');
    }
}