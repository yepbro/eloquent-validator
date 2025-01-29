<?php

namespace YepBro\EloquentValidator\Tests\Feature\Rules\Database;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use YepBro\EloquentValidator\Tests\Feature\FeatureTestCase;

class ExistsRuleTest extends FeatureTestCase
{
    use DatabaseMigrations;

    public function test_ok()
    {
        $this->markTestSkipped();
    }
}