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
class AlphaRuleTest extends RuleTestCase
{
    use DatabaseMigrations;

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith(['aaa^gg'])]
    #[TestWith(['aaa_gg'])]
    #[TestWith(['aaa-gg'])]
    #[TestWith(['aaa1gg'])]
    #[TestWith(['аврора^gg', ':ascii'])]
    public function test_validation_of_incorrect_data_with_a_stringable_rule(mixed $value, string $param = '')
    {
        $this->testException("alpha$param", $value, 'alpha');
    }

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith(['aaa'])]
    #[TestWith(['проверка'])]
    #[TestWith(['test', ':ascii'])]
    public function test_validation_of_correct_data_with_a_stringable_rule(mixed $value, string $param = '')
    {
        $this->testSuccess("alpha$param", $value);
    }
}