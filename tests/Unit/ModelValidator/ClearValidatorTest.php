<?php
declare(strict_types=1);

namespace YepBro\EloquentValidator\Tests\Unit\ModelValidator;

use Illuminate\Translation\ArrayLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Validator;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\Group;
use YepBro\EloquentValidator\ModelValidator;
use YepBro\EloquentValidator\Tests\Unit\UnitTestCase;

#[CoversMethod(ModelValidator::class, 'clearValidator')]
#[Group('ModelValidator')]
class ClearValidatorTest extends UnitTestCase
{
    public function test_clear_validator_instance(): void
    {
        $laravelValidator = new Validator(new Translator(new ArrayLoader, 'en'), [], []);
        $validator = $this->getMockModelValidator([], ['validator' => $laravelValidator]);
        $validator->magicCallMethod('clearValidator');
        $this->assertFalse($validator->testIsValidatorInit());
    }
}