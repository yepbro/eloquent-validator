<?php

namespace YepBro\EloquentValidator\Tests\Unit\HasValidatorTrait;

use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\MockObject\Exception;
use YepBro\EloquentValidator\Exceptions\ModelValidatorNotFound;
use YepBro\EloquentValidator\HasValidator;
use YepBro\EloquentValidator\ModelValidator;
use YepBro\EloquentValidator\Tests\Unit\Mocks\MockModel;
use YepBro\EloquentValidator\Tests\Unit\Mocks\MockModelValidator;
use YepBro\EloquentValidator\Tests\Unit\UnitTestCase;

#[CoversMethod(HasValidator::class, 'getModelValidatorInstance')]
class GetValidatorInstanceTest extends UnitTestCase
{
    public function test_validator_not_found(): void
    {
        $class = new class extends Model {
            use HasValidator;
        };

        $this->expectException(ModelValidatorNotFound::class);

        $class->getModelValidatorInstance();
    }

    public function test_if_get_validator_class_method_defined(): void
    {
        $class = new class extends Model {
            use HasValidator;

            protected function getModelValidatorClass(string $modelPath): string
            {
                return MockModelValidator::class;
            }
        };

        $this->assertInstanceOf(ModelValidator::class, $class->getModelValidatorInstance());
    }

    public function test_if_validator_class_property_defined(): void
    {
        $class = new class extends Model {
            use HasValidator;

            public string $validatorClass = MockModelValidator::class;
        };

        $this->assertInstanceOf(ModelValidator::class, $class->getModelValidatorInstance());
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

        $this->assertInstanceOf(ModelValidator::class, new MockModel()->getModelValidatorInstance());
    }
}