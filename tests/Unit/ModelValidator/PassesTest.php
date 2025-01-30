<?php
declare(strict_types=1);

namespace YepBro\EloquentValidator\Tests\Unit\ModelValidator;

use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestWith;
use YepBro\EloquentValidator\ModelValidator;
use YepBro\EloquentValidator\Tests\Unit\UnitTestCase;

#[CoversMethod(ModelValidator::class, 'passes')]
#[Group('ModelValidator')]
class PassesTest extends UnitTestCase
{
    #[TestWith([['a' => 1, 'b' => 's'], ['a' => 'integer', 'b' => 'string']])]
    public function test_success(array $data, array $rules): void
    {
        $validator = $this->getMockModelValidator(['original' => $data], ['rules' => $rules]);

        $this->assertTrue($validator->passes());
    }
}