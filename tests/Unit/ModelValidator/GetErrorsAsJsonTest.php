<?php
declare(strict_types=1);

namespace YepBro\EloquentValidator\Tests\Unit\ModelValidator;

use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestWith;
use YepBro\EloquentValidator\ModelValidator;
use YepBro\EloquentValidator\Tests\Unit\UnitTestCase;

#[CoversMethod(ModelValidator::class, 'getErrorsAsJson')]
#[Group('ModelValidator')]
class GetErrorsAsJsonTest extends UnitTestCase
{
    #[TestWith([['a' => 1, 'b' => 's'], ['a' => 'string', 'b' => 'string']])]
    public function test_success(array $data, array $rules): void
    {
        $validator = $this->getMockModelValidator(['original' => $data], ['rules' => $rules]);

        $expected = json_encode(['a' => ['validation.string']]);

        $this->assertSame($expected, $validator->getErrorsAsJson());
    }
}