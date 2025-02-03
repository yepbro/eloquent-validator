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
class EmailRuleTest extends RuleTestCase
{
    use DatabaseMigrations;

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith(['email'])]
    #[TestWith(['email@.com', ':rfc'])]
    #[TestWith(['email..to@domain.com', ':strict'])]
    #[TestWith(['email.@domain.com', ':strict'])]
    #[TestWith(['email@laravel.kids', ':dns'])]
    #[TestWith(['еmail@domain.com', ':spoof'])]
    #[TestWith(['email@domain', ':filter'])]
    #[TestWith(['емейл@домен.ру', ':filter'])]
    #[TestWith(['емейл@домен', ':filter_unicode'])]
    public function test_validation_of_incorrect_data_with_a_stringable_rule(mixed $value, string $param = '')
    {
        $this->testException("email$param", $value, 'email');
    }

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith(['denis@yepbro.ru'])]
    #[TestWith(['denis@yepbro.ru', ':rfc'])]
    #[TestWith(['denis+laravel@yepbro.ru', ':strict'])]
    #[TestWith(['denis@yepbro.ru', ':dns'])]
    #[TestWith(['denis@yepbro.ru', ':spoof'])]
    #[TestWith(['denis@yepbro.ru', ':filter'])]
    #[TestWith(['емейл@yepbro.ru', ':filter_unicode'])]
    public function test_validation_of_correct_data_with_a_stringable_rule(mixed $value, string $param = '')
    {
        $this->testSuccess("email$param", $value);
    }
}