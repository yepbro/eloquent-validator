<?php

namespace YepBro\EloquentValidator\Tests\Feature\Rules\Strings;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestWith;
use YepBro\EloquentValidator\Exceptions\ModelValidatorNotFound;
use YepBro\EloquentValidator\Tests\Feature\FeatureTestCase;
use YepBro\EloquentValidator\Tests\Feature\Rules\RuleTestCase;

#[Group('Rules')]
#[Group('StringRules')]
class AlphaDashRuleTest extends RuleTestCase
{
    use DatabaseMigrations;

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith(['aaa^gg'])]
    #[TestWith(['аврора^gg', ':ascii'])]
    public function test_validation_of_incorrect_data_with_a_stringable_rule(mixed $value, string $param = '')
    {
        $this->testException("alpha_dash$param", $value, 'alpha_dash');
    }

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith(['aaa-g_g'])]
    #[TestWith(['про_вер_ка-два'])]
    #[TestWith(['test_gg', ':ascii'])]
    public function test_validation_of_correct_data_with_a_stringable_rule(mixed $value, string $param = '')
    {
        $this->testSuccess("alpha_dash$param", $value);
    }
}