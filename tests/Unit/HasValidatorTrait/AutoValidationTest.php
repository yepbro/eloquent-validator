<?php

namespace YepBro\EloquentValidator\Tests\Unit\HasValidatorTrait;

use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\Group;
use YepBro\EloquentValidator\HasValidator;
use YepBro\EloquentValidator\Tests\Unit\Mocks\MagicalAccessTrait;
use YepBro\EloquentValidator\Tests\Unit\UnitTestCase;
use YepBro\EloquentValidator\Validatable;

#[CoversMethod(HasValidator::class, 'hasValidatableInterface')]
#[Group('HasValidatorTrait')]
class AutoValidationTest extends UnitTestCase
{
    public function test_model_has_validatable_interface(): void
    {
        $model = new class implements Validatable {
            use HasValidator, MagicalAccessTrait;
        };
        $this->assertTrue($model->magicCallMethod('hasValidatableInterface'));
    }

    public function test_model_has_not_validatable_interface(): void
    {
        $model = new class {
            use HasValidator, MagicalAccessTrait;
        };
        $this->assertFalse($model->magicCallMethod('hasValidatableInterface'));
    }
}