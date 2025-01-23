<?php
declare(strict_types=1);

namespace YepBro\EloquentValidator\Tests\Unit\ModelValidator;

use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestWith;
use YepBro\EloquentValidator\ModelValidator;
use YepBro\EloquentValidator\Tests\Unit\UnitTestCase;

#[CoversMethod(ModelValidator::class, 'getModelData')]
#[Group('ModelValidator')]
class GetModelDataTest extends UnitTestCase
{
    #[TestWith([['a' => 1, 'b' => 's'], ['a' => 'required', 'b' => 'required']])]
    #[TestWith([['a' => 1, 'b' => 2, 'c' => 'x'], ['a' => 'int', 'b' => 'int'], ['a' => 1, 'b' => 2]])]
    public function test_success(array $data, array $rules, array $expected = []): void
    {
        $validator = $this->getMockModelValidator(['original' => $data], ['rules' => $rules]);

        $this->assertSame($expected ?: $data, $validator->magicCallMethod('getModelData'));
    }
}