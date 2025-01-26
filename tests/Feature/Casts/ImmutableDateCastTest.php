<?php

namespace YepBro\EloquentValidator\Tests\Feature\Casts;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use YepBro\EloquentValidator\Tests\Feature\FeatureTestCase;

class ImmutableDateCastTest extends FeatureTestCase
{
    use DatabaseMigrations;

    protected bool $fakeProduct = false;
}