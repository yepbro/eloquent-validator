<?php

namespace YepBro\EloquentValidator\Tests\Unit\HasValidatorTrait;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\TestWith;
use YepBro\EloquentValidator\Exceptions\ModelNotValidated;
use YepBro\EloquentValidator\Exceptions\ModelValidatorNotFound;
use YepBro\EloquentValidator\HasValidator;
use YepBro\EloquentValidator\Tests\Unit\UnitTestCase;

#[CoversClass(HasValidator::class)]
#[Group('HasValidatorTrait')]
class WithValidationTest extends UnitTestCase
{
    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith(['saveWithValidation'])]
    #[TestWith(['saveOrFailWithValidation'])]
    #[TestWith(['saveQuietlyWithValidation'])]
    #[TestDox('$method is ok')]
    public function test_save_exception(string $method): void
    {
        $data = ['a' => 1.5, 'b' => 's'];
        $rules = ['a' => 'required|integer', 'b' => 'required|string'];

        $model = $this->getMockModel(['original' => $data], ['rules' => $rules]);

        $this->expectException(ModelNotValidated::class);

        $model->{$method}();
    }

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith(['updateWithValidation'])]
    #[TestWith(['updateOrFailWithValidation'])]
    #[TestWith(['updateQuietlyWithValidation'])]
    #[TestDox('$method is ok')]
    public function test_update_exception(string $method): void
    {
        $data = ['a' => 1.5, 'b' => 's'];
        $rules = ['a' => 'integer', 'b' => 'string'];

        $model = $this->getMockModel(['original' => [], 'exists' => true], ['rules' => $rules]);

        $this->expectException(ModelNotValidated::class);

        $model->{$method}($data);
    }

    #[TestWith(['fillWithValidation'])]
    #[TestWith(['forceFillWithValidation'])]
    #[TestDox('$method is ok')]
    public function test_fill_exception(string $method): void
    {
        $data = ['a' => 1.5, 'b' => 's'];
        $rules = ['a' => 'integer', 'b' => 'string'];

        $model = $this->getMockModel(['original' => []], ['rules' => $rules]);

        $this->expectException(ModelNotValidated::class);

        $model->{$method}($data);
    }
}