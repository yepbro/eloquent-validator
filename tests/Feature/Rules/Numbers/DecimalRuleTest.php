<?php

namespace YepBro\EloquentValidator\Tests\Feature\Rules\Numbers;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use YepBro\EloquentValidator\Tests\Feature\FeatureTestCase;

class DecimalRuleTest extends FeatureTestCase
{
    use DatabaseMigrations;

    public function test_ok()
    {
        $this->markTestSkipped();
    }
}