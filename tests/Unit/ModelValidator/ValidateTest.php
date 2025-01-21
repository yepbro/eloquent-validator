<?php
declare(strict_types=1);

namespace YepBro\EloquentValidator\Tests\Unit\ModelValidator;

use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestWith;
use YepBro\EloquentValidator\Exceptions\ModelNotValidated;
use YepBro\EloquentValidator\ModelValidator;
use YepBro\EloquentValidator\Tests\Unit\Mocks\MockModel;
use YepBro\EloquentValidator\Tests\Unit\Mocks\MockModelValidator;
use YepBro\EloquentValidator\Tests\Unit\UnitTestCase;

#[CoversMethod(ModelValidator::class, 'validate')]
#[Group('ModelValidator')]
class ValidateTest extends UnitTestCase
{
    /**
     * @throws ModelNotValidated
     */
    #[TestWith([['a' => 1, 'b' => 's'], ['a' => 'string', 'b' => 'string']])]
    public function test_exception(array $data, array $rules): void
    {
        $model = new MockModel;
        $model->magicSetProperty('original', $data);

        $validator = new MockModelValidator($model);
        $validator->setRules($rules);

        $this->expectException(ModelNotValidated::class);

        $validator->validate();
    }

    #[TestWith([['a' => 1, 'b' => 's'], ['a' => 'string', 'b' => 'string']])]
    public function test_get_validation_errors_from_exception(array $data, array $rules): void
    {
        $model = new MockModel;
        $model->magicSetProperty('original', $data);

        $validator = new MockModelValidator($model);
        $validator->setRules($rules);

        try {
            $validator->validate();
        } catch (ModelNotValidated $e) {
            $this->assertSame(
                ['a' => ['validation.string']],
                $e->errors,
            );
        }
    }

    /**
     * @throws ModelNotValidated
     */
    #[TestWith([['a' => 1, 'b' => 's'], ['a' => 'string', 'b' => 'string']])]
    public function test_message_in_exception(array $data, array $rules): void
    {
        $model = new MockModel;
        $model->magicSetProperty('original', $data);

        $validator = new MockModelValidator($model);
        $validator->setRules($rules);

        $modelClass = $model::class;
        $this->expectExceptionMessage("Model $modelClass not validated");
        $validator->validate();
    }
}