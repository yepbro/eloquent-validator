<?php

namespace YepBro\EloquentValidator\Tests\Feature\Rules\Strings;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use YepBro\EloquentValidator\Tests\Feature\FeatureTestCase;

class ConfirmedRuleTest extends FeatureTestCase
{
    use DatabaseMigrations;

    public function test_skip()
    {
        $this->markTestSkipped('The validation rule is not applicable to models.');
    }
}