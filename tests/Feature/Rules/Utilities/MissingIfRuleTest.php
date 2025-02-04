<?php

namespace YepBro\EloquentValidator\Tests\Feature\Rules\Utilities;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use PHPUnit\Framework\Attributes\Group;
use YepBro\EloquentValidator\Tests\Feature\FeatureTestCase;
use YepBro\EloquentValidator\Tests\Feature\Rules\RuleTestCase;

#[Group('Rules')]
#[Group('UtilityRules')]
class MissingIfRuleTest extends RuleTestCase
{
    use DatabaseMigrations;

    public function test_skip()
    {
        $this->markTestIncomplete('The validation rule is not applicable to models.');
    }
}