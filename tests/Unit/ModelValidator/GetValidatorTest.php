<?php
declare(strict_types=1);

namespace YepBro\EloquentValidator\Tests\Unit\ModelValidator;

use Illuminate\Validation\Validator;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\Group;
use YepBro\EloquentValidator\ModelValidator;
use YepBro\EloquentValidator\Tests\Unit\Mocks\MockModel;
use YepBro\EloquentValidator\Tests\Unit\Mocks\MockModelValidator;
use YepBro\EloquentValidator\Tests\Unit\UnitTestCase;

#[CoversMethod(ModelValidator::class, 'getValidator')]
#[Group('ModelValidator')]
class GetValidatorTest extends UnitTestCase
{
    public function test_success(): void
    {
        $mockValidator = new MockModelValidator(new MockModel);

        $this->assertInstanceOf(Validator::class, $mockValidator->getValidator());
    }
}