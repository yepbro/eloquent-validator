<?php

namespace YepBro\EloquentValidator\Tests\Unit\HasValidatorTrait;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\MockObject\Exception;
use YepBro\EloquentValidator\HasValidator;
use YepBro\EloquentValidator\Tests\Unit\Mocks\MockModel;
use YepBro\EloquentValidator\Tests\Unit\UnitTestCase;

#[CoversClass(HasValidator::class)]
#[Group('HasValidatorTrait')]
class GetNamespaceTest extends UnitTestCase
{
    /**
     * @throws Exception
     */
    public function test_get_model_namespace(): void
    {
        $mock = $this->createPartialMock(MockModel::class, ['getModelNamespace']);

        $mock
            ->method('getModelNamespace')
            ->willReturn("App\Models");

        $this->assertSame('App\Models', $mock->magicCallMethod('getModelNamespace'));
    }

    /**
     * @throws Exception
     */
    public function test_get_validator_namespace(): void
    {
        $mock = $this->createPartialMock(MockModel::class, ['getModelValidatorNamespace']);

        $mock
            ->method('getModelValidatorNamespace')
            ->willReturn("App\Validators");

        $this->assertSame('App\Validators', $mock->magicCallMethod('getModelValidatorNamespace'));
    }
}