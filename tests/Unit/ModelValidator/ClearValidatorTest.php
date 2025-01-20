<?php

namespace YepBro\EloquentValidator\Tests\Unit\ModelValidator;

use Illuminate\Translation\ArrayLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Validator;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\Group;
use YepBro\EloquentValidator\ModelValidator;
use YepBro\EloquentValidator\Tests\Unit\Mocks\MockModel;
use YepBro\EloquentValidator\Tests\Unit\Mocks\MockModelValidator;
use YepBro\EloquentValidator\Tests\Unit\UnitTestCase;

#[CoversMethod(ModelValidator::class, 'clearValidator')]
#[Group('ModelValidator')]
class ClearValidatorTest extends UnitTestCase
{
    public function test_clear_validator_instance(): void
    {
        $obj = $this->getMockObject(
            'validator',
            new Validator(new Translator(new ArrayLoader, 'en'), [], [])
        );
        $obj->magicCallMethod('clearValidator');
        $this->assertFalse($obj->testIsValidatorInit());
    }

    protected function getMockObject(?string $property = null, array|Validator|null $value = null): object
    {
        return new class($property, $value) extends MockModelValidator {
            public function __construct(?string $property = null, array|Validator|null $value = null)
            {
                parent::__construct(new MockModel);

                if ($property !== null && $value !== null) {
                    $this->{$property} = $value;
                }
            }

            public function testIsValidatorInit(): bool
            {
                return isset($this->validator);
            }
        };
    }
}