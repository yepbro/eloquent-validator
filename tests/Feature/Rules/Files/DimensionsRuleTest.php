<?php

namespace YepBro\EloquentValidator\Tests\Feature\Rules\Files;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use PHPUnit\Framework\Attributes\Group;
use YepBro\EloquentValidator\Tests\Feature\FeatureTestCase;

#[Group('Rules')]
#[Group('FileRules')]
class DimensionsRuleTest extends FeatureTestCase
{
    use DatabaseMigrations;

    public function test_skip()
    {
        $this->markTestSkipped('The validation rule is not applicable to models.');
    }
}