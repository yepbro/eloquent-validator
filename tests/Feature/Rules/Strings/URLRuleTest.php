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
class URLRuleTest extends RuleTestCase
{
    use DatabaseMigrations;

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith(['ya.ru'])]
    #[TestWith(['https://ya.ru', ':http'])]
    #[TestWith(['minecraft://ya.ru'])]
    #[TestWith(['not_url'])]
    public function test_validation_of_incorrect_data_with_a_stringable_rule(mixed $value, string $scheme = '')
    {
        $this->testException("url$scheme", $value, 'url');
    }

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith(['https://ya.ru', ':https'])]
    #[TestWith(['https://mail.ru'])]
    #[TestWith(['minecraft://ya.ru', ':minecraft'])]
    public function test_validation_of_correct_data_with_a_stringable_rule(mixed $value, string $scheme = '')
    {
        $this->testSuccess("url$scheme", $value);
    }
}