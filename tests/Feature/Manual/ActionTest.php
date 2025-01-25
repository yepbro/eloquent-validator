<?php

namespace YepBro\EloquentValidator\Tests\Feature\Manual;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\TestWith;
use YepBro\EloquentValidator\Exceptions\ModelNotValidated;
use YepBro\EloquentValidator\Exceptions\ModelValidatorNotFound;
use YepBro\EloquentValidator\HasValidator;
use YepBro\EloquentValidator\Tests\Feature\TestCase;

#[CoversMethod(HasValidator::class, 'fillWithValidation')]
#[CoversMethod(HasValidator::class, 'forceFillWithValidation')]
#[CoversMethod(HasValidator::class, 'updateWithValidation')]
#[CoversMethod(HasValidator::class, 'updateOrFailWithValidation')]
#[CoversMethod(HasValidator::class, 'updateQuietlyWithValidation')]
#[CoversMethod(HasValidator::class, 'saveWithValidation')]
#[CoversMethod(HasValidator::class, 'saveOrFailWithValidation')]
#[CoversMethod(HasValidator::class, 'saveQuietlyWithValidation')]
class ActionTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @throws ModelValidatorNotFound
     * @throws ModelNotValidated
     */
    #[TestWith(['fillWithValidation'])]
    #[TestWith(['forceFillWithValidation'])]
    #[TestDox('Method $method is ok')]
    public function test_fill_ok(string $method): void
    {
        $data = ['name' => Str::random()];
        $model = $this->getProduct();
        $model->{$method}($data);
        $this->assertSame($model->name, $data['name']);
    }

    #[TestWith(['updateWithValidation'])]
    #[TestWith(['updateOrFailWithValidation'])]
    #[TestWith(['updateQuietlyWithValidation'])]
    #[TestDox('Method $method is ok')]
    public function test_update_ok(string $method): void
    {
        $data = ['name' => Str::random()];
        $model = $this->getProduct();
        $model->{$method}($data);
        $this->assertSame($model->name, $data['name']);
        $this->assertDatabaseHas($model, $data);
    }

    #[TestWith(['saveWithValidation'])]
    #[TestWith(['saveOrFailWithValidation'])]
    #[TestWith(['saveQuietlyWithValidation'])]
    #[TestDox('Method $method is ok')]
    public function test_save_ok(string $method): void
    {
        $data = ['name' => Str::random()];
        $model = $this->getProduct();
        $model->fill($data)->{$method}();
        $this->assertSame($model->name, $data['name']);
        $this->assertDatabaseHas($model, $data);
    }

    /**
     * @throws ModelValidatorNotFound
     * @throws ModelNotValidated
     */
    #[TestWith(['fillWithValidation', 'fill'])]
    #[TestWith(['forceFillWithValidation', 'fill'])]
    #[TestWith(['updateWithValidation', 'fill'])]
    #[TestWith(['updateOrFailWithValidation', 'fill'])]
    #[TestWith(['updateQuietlyWithValidation', 'fill'])]
    #[TestWith(['saveWithValidation', 'save'])]
    #[TestWith(['saveOrFailWithValidation', 'save'])]
    #[TestWith(['saveQuietlyWithValidation', 'save'])]
    #[TestDox('Method $method threw exception')]
    public function test_exception(string $method, string $type): void
    {
        $model = $this->getProduct();
        $data = ['name' => null];
        $this->expectException(ModelNotValidated::class);
        $type === 'fill' ? $model->{$method}($data) : $model->fill($data)->{$method}();
    }
}