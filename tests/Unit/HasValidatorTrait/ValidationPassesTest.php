<?php

namespace YepBro\EloquentValidator\Tests\Unit\HasValidatorTrait;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestWith;
use YepBro\EloquentValidator\Exceptions\ModelValidatorNotFound;
use YepBro\EloquentValidator\HasValidator;
use YepBro\EloquentValidator\Tests\Unit\UnitTestCase;

#[CoversClass(HasValidator::class)]
#[Group('HasValidatorTrait')]
class ValidationPassesTest extends UnitTestCase
{
    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith([['a' => 1, 'b' => 's'], ['a' => 'int', 'b' => 'string']])]
    public function test_success(array $data, array $rules): void
    {
        $model = $this->getMockModel(['original' => $data], ['rules' => $rules]);

        $this->assertTrue($model->validationPasses());
    }
}