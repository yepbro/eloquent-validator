<?php

namespace YepBro\EloquentValidator\Tests\Unit\HasValidatorTrait;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestWith;
use YepBro\EloquentValidator\Exceptions\ModelNotValidated;
use YepBro\EloquentValidator\Exceptions\ModelValidatorNotFound;
use YepBro\EloquentValidator\HasValidator;
use YepBro\EloquentValidator\Tests\Unit\UnitTestCase;

#[CoversClass(HasValidator::class)]
#[Group('HasValidatorTrait')]
class ValidateTest extends UnitTestCase
{
    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith([['a' => 1.5, 'b' => 's'], ['a' => 'int', 'b' => 'string']])]
    public function test_exception(array $data, array $rules): void
    {
        $model = $this->getMockModel(['original' => $data], ['rules' => $rules]);

        $this->expectException(ModelNotValidated::class);

        $model->validate();
    }

    /**
     * @throws ModelValidatorNotFound
     * @throws ModelNotValidated
     */
    #[TestWith([['a' => 'null', 'b' => 's'], ['a' => 'string', 'b' => 'string']])]
    public function test_success_validate(array $data, array $rules): void
    {
        $model = $this->getMockModel(['original' => $data], ['rules' => $rules]);

        $model->validate();
    }
}