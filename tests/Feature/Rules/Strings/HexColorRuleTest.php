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
class HexColorRuleTest extends RuleTestCase
{
    use DatabaseMigrations;

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith(['grey'])]
    #[TestWith(['00FFFF'])]
    public function test_validation_of_incorrect_data_with_a_stringable_rule(mixed $value)
    {
        $this->testException('hex_color', $value);
    }

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith(['#000'])]
    #[TestWith(['#FF00'])]
    #[TestWith(['#FFBBCC'])]
    #[TestWith(['#FFBBCC01'])]
    public function test_validation_of_correct_data_with_a_stringable_rule(mixed $value)
    {
        $this->testSuccess('hex_color', $value);
    }
}