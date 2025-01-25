<?php

namespace YepBro\EloquentValidator\Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use PHPUnit\Framework\Attributes\CoversMethod;
use YepBro\EloquentValidator\Exceptions\ModelNotValidated;
use YepBro\EloquentValidator\Exceptions\ModelValidatorNotFound;
use YepBro\EloquentValidator\HasValidator;

#[CoversMethod(HasValidator::class, 'validate')]
class AfterChangeModelDataTest extends FeatureTestCase
{
    use DatabaseMigrations;

    protected bool $fakeProduct = true;

    /**
     * @throws ModelValidatorNotFound
     * @throws ModelNotValidated
     */
    public function test_success(): void
    {
        $this->product->name = 'test';
        $this->product->validate();

        $this->product->name = null;
        $this->expectException(ModelNotValidated::class);
        $this->product->validate();
    }
}