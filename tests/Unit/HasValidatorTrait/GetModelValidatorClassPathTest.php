<?php

namespace YepBro\EloquentValidator\Tests\Unit\HasValidatorTrait;

use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\MockObject\Exception;
use YepBro\EloquentValidator\HasValidator;
use YepBro\EloquentValidator\Tests\Unit\Mocks\CallProtectedMethods;
use YepBro\EloquentValidator\Tests\Unit\Mocks\MockModel;
use YepBro\EloquentValidator\Tests\Unit\UnitTestCase;

#[CoversMethod(HasValidator::class, 'getModelValidatorClassPath')]
class GetModelValidatorClassPathTest extends UnitTestCase
{
    #[TestWith(['App\Models\User', 'App\ModelValidators\UserValidator'])]
    #[TestWith(['App\Models\Users\Manager', 'App\ModelValidators\Users\ManagerValidator'])]
    #[TestWith(['App\Models\Users\Admins\RootUser', 'App\ModelValidators\Users\Admins\RootUserValidator'])]
    #[TestDox('$modelClass => $validatorClass')]
    public function test_models_and_validators_in_default_folder(string $modelClass, string $validatorClass): void
    {
        $class = new class {
            use CallProtectedMethods, HasValidator;
        };

        $this->assertSame($validatorClass, $class->callMethod('getModelValidatorClass', $modelClass));
    }

    #[TestWith(['App\Models\Admin', 'App\ModelValidators\UserValidator'])]
    #[TestDox('$modelClass => $validatorClass')]
    public function test_defined_validator_class_property(string $modelClass, string $validatorClass): void
    {
        $class = new class {
            use CallProtectedMethods, HasValidator;

            protected $validatorClass = 'App\ModelValidators\UserValidator';
        };

        $this->assertSame($validatorClass, $class->callMethod('getModelValidatorClass', $modelClass));
    }

    /**
     * @throws Exception
     */
    #[TestWith(['App\Models\User', 'App\Models\Validators\UserValidator'])]
    #[TestWith(['App\Models\Users\Manager', 'App\Models\Validators\Users\ManagerValidator'])]
    #[TestWith(['App\Models\Users\Admins\RootUser', 'App\Models\Validators\Users\Admins\RootUserValidator'])]
    #[TestDox('$modelClass => $validatorClass')]
    public function test_models_in_default_folder_and_validators_nested(string $modelClass, string $validatorClass): void
    {
        $mock = $this->createPartialMock(MockModel::class, ['getModelValidatorNamespace']);

        $mock
            ->method('getModelValidatorNamespace')
            ->willReturn("App\\Models\\Validators\\");

        $this->assertSame($validatorClass, $mock->callMethod('getModelValidatorClass', $modelClass));
    }
}