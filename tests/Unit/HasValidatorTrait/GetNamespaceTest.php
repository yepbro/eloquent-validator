<?php

namespace Unit\HasValidatorTrait;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use YepBro\EloquentValidator\HasValidator;
use YepBro\EloquentValidator\Tests\Unit\UnitTestCase;

#[CoversClass(HasValidator::class)]
#[Group('HasValidatorTrait')]
class GetNamespaceTest extends UnitTestCase
{
    public function test_get_model_namespace(): void
    {
        $model = $this->getMockModel();

        $this->assertSame('App\\Models\\', $model->magicCallMethod('getModelNamespace'));
    }

    public function test_get_validator_namespace(): void
    {
        $model = $this->getMockModel();

        $this->assertSame('App\\ModelValidators\\', $model->magicCallMethod('getModelValidatorNamespace'));
    }
}