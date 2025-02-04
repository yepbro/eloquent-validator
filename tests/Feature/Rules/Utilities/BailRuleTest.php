<?php

namespace YepBro\EloquentValidator\Tests\Feature\Rules\Utilities;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\Group;
use YepBro\EloquentValidator\Exceptions\ModelValidatorNotFound;
use YepBro\EloquentValidator\Tests\Feature\FeatureTestCase;
use YepBro\EloquentValidator\Tests\Feature\Rules\RuleTestCase;

#[Group('Rules')]
#[Group('UtilityRules')]
class BailRuleTest extends RuleTestCase
{
    use DatabaseMigrations;

    /**
     * @throws ModelValidatorNotFound
     */
    public function test_success()
    {
        $this->testException('bail|integer|min:5', null, 'integer');
    }
}