<?php

namespace YepBro\EloquentValidator\Tests\Feature\Rules\Strings;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestWith;
use YepBro\EloquentValidator\Exceptions\ModelValidatorNotFound;
use YepBro\EloquentValidator\Tests\Feature\Rules\RuleTestCase;

#[Group('Rules')]
#[Group('StringRules')]
class IP4AddressRuleTest extends RuleTestCase
{
    use DatabaseMigrations;

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith(['test.ru'])]
    #[TestWith(['127.0.0.500'])]
    #[TestWith(['fe00:0000:0000:0001:0000:0000:0000:0092'])]
    public function test_validation_of_incorrect_data_with_a_stringable_rule(mixed $value)
    {
        $this->testException('ipv4', $value);
    }

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith(['127.0.0.1'])]
    public function test_validation_of_correct_data_with_a_stringable_rule(mixed $value)
    {
        $this->testSuccess('ipv4', $value);
    }
}