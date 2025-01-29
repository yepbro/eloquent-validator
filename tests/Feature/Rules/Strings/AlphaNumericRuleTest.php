<?php

namespace YepBro\EloquentValidator\Tests\Feature\Rules\Strings;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use YepBro\EloquentValidator\Tests\Feature\FeatureTestCase;

class AlphaNumericRuleTest extends FeatureTestCase
{
    use DatabaseMigrations;

    public function test_ok()
    {
        $this->markTestSkipped();
    }
}