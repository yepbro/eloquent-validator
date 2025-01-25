<?php

namespace YepBro\EloquentValidator\Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\TestWith;
use YepBro\EloquentValidator\Exceptions\ModelNotValidated;
use YepBro\EloquentValidator\Exceptions\ModelValidatorNotFound;
use YepBro\EloquentValidator\HasValidator;

#[CoversMethod(HasValidator::class, 'fillWithValidation')]
#[CoversMethod(HasValidator::class, 'forceFillWithValidation')]
#[CoversMethod(HasValidator::class, 'updateWithValidation')]
#[CoversMethod(HasValidator::class, 'updateOrFailWithValidation')]
#[CoversMethod(HasValidator::class, 'updateQuietlyWithValidation')]
#[CoversMethod(HasValidator::class, 'saveWithValidation')]
#[CoversMethod(HasValidator::class, 'saveOrFailWithValidation')]
#[CoversMethod(HasValidator::class, 'saveQuietlyWithValidation')]
class ActionTest extends FeatureTestCase
{
    use DatabaseMigrations;

    protected bool $fakeProduct = true;

    #[TestWith(['saveWithValidation'])]
    #[TestWith(['saveOrFailWithValidation'])]
    #[TestWith(['saveQuietlyWithValidation'])]
    #[TestDox('Method $method is ok')]
    public function test_save_ok(string $method): void
    {
        $data = ['name' => Str::random()];
        $this->product->fill($data)->{$method}();
        $this->assertSame($this->product->name, $data['name']);
        $this->assertDatabaseHas($this->product, $data);
    }

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
        $this->product->{$method}($data);
        $this->assertSame($this->product->name, $data['name']);
    }

    #[TestWith(['updateWithValidation'])]
    #[TestWith(['updateOrFailWithValidation'])]
    #[TestWith(['updateQuietlyWithValidation'])]
    #[TestDox('Method $method is ok')]
    public function test_update_ok(string $method): void
    {
        $data = ['name' => Str::random()];
        $this->product->{$method}($data);
        $this->assertSame($this->product->name, $data['name']);
        $this->assertDatabaseHas($this->product, $data);
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
        $data = ['name' => null];
        $this->expectException(ModelNotValidated::class);
        $type === 'fill' ? $this->product->{$method}($data) : $this->product->fill($data)->{$method}();
    }

    #[TestWith(['fillWithValidation', 'fill'])]
    #[TestWith(['forceFillWithValidation', 'fill'])]
    #[TestWith(['updateWithValidation', 'fill'])]
    #[TestWith(['updateOrFailWithValidation', 'fill'])]
    #[TestWith(['updateQuietlyWithValidation', 'fill'])]
    #[TestWith(['saveWithValidation', 'save'])]
    #[TestWith(['saveOrFailWithValidation', 'save'])]
    #[TestWith(['saveQuietlyWithValidation', 'save'])]
    #[TestDox('Method $method threw exception with correct data')]
    public function test_exception_message_and_errors(string $method, string $type)
    {
        $model = $this->getProduct();
        $data = ['name' => null, 'price' => 'a'];
        try {
            $type === 'fill' ? $this->product->{$method}($data) : $this->product->fill($data)->{$method}();
        } catch (ModelNotValidated $e) {
            $modelName = get_class($this->product);
            $this->assertSame($e->getMessage(), "Model $modelName not validated");
            $this->assertEqualsCanonicalizing([
                'price' => ['The price field must be a number.'],
                'name' => ['Product name is mandatory.'],
            ], $e->errors);
        }
    }
}