<?php

namespace YepBro\EloquentValidator\Tests\HasValidatorTrait;

use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\MockObject\Exception;
use YepBro\EloquentValidator\Exceptions\ModelValidatorNotFound;
use YepBro\EloquentValidator\HasValidator;
use YepBro\EloquentValidator\ModelValidator;
use YepBro\EloquentValidator\Tests\Mocks\MockModel;
use YepBro\EloquentValidator\Tests\Mocks\MockModelValidator;
use YepBro\EloquentValidator\Tests\UnitTestCase;

#[CoversMethod(HasValidator::class, 'getValidatorInstance')]
class GetValidatorInstanceTest extends UnitTestCase
{
    public function test_validator_not_found(): void
    {
        $class = new class {
            use HasValidator;
        };

        $this->expectException(ModelValidatorNotFound::class);

        $class->getValidatorInstance();
    }

    public function test_if_get_validator_class_method_defined(): void
    {
        $class = new class {
            use HasValidator;

            protected function getModelValidatorClass(string $modelPath): string
            {
                return MockModelValidator::class;
            }
        };

        $this->assertInstanceOf(ModelValidator::class, $class->getValidatorInstance());
    }

    public function test_if_validator_class_property_defined(): void
    {
        $class = new class {
            use HasValidator;

            public string $validatorClass = MockModelValidator::class;
        };

        $this->assertInstanceOf(ModelValidator::class, $class->getValidatorInstance());
    }

    /**
     * @throws ModelValidatorNotFound
     * @throws Exception
     */
    public function test_if_validator_class_default(): void
    {
        $mock = $this->createPartialMock(MockModel::class, [
            'getModelNamespace',
            'getModelValidatorNamespace',
        ]);

        $mock
            ->method('getModelNamespace')
            ->willReturn("YepBro\\EloquentValidator\\Tests\\Mocks\\");

        $mock
            ->method('getModelValidatorNamespace')
            ->willReturn("YepBro\\EloquentValidator\\Tests\\Mocks\\");

        $this->assertInstanceOf(ModelValidator::class, new MockModel()->getValidatorInstance());
    }
}