<?php

namespace YepBro\EloquentValidator\Tests\Feature\Rules\Utilities;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use YepBro\EloquentValidator\Tests\Feature\FeatureTestCase;

class ExcludeRuleTest extends FeatureTestCase
{
    use DatabaseMigrations;

    public function test_ok()
    {
        $this->markTestSkipped();
    }
}