<?php

namespace YepBro\EloquentValidator\Tests\Unit\ModelValidator;

use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestWith;
use YepBro\EloquentValidator\ModelValidator;
use YepBro\EloquentValidator\Tests\Unit\Mocks\MockModel;
use YepBro\EloquentValidator\Tests\Unit\Mocks\MockModelValidator;
use YepBro\EloquentValidator\Tests\Unit\UnitTestCase;

#[CoversMethod(ModelValidator::class, 'getErrorsAsArray')]
#[Group('ModelValidator')]
class GetErrorsAsArrayTest extends UnitTestCase
{
    #[TestWith([['a' => 1, 'b' => 's'], ['a' => 'string', 'b' => 'string']])]
    public function test_success(array $data, array $rules): void
    {
        $model = new MockModel;
        $model->magicSetOriginal($data);

        $validator = new MockModelValidator($model);
        $validator->setRules($rules);

        $this->assertSame(['a' => ['validation.string']], $validator->getErrorsAsArray());
    }
}