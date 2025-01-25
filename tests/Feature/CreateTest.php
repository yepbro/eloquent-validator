<?php

namespace YepBro\EloquentValidator\Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\TestWith;
use Workbench\App\Models\Product;
use YepBro\EloquentValidator\Exceptions\ModelNotValidated;
use YepBro\EloquentValidator\Exceptions\ModelValidatorNotFound;
use YepBro\EloquentValidator\HasValidator;

#[CoversMethod(HasValidator::class, 'createWithValidation')]
#[CoversMethod(HasValidator::class, 'createQuietlyWithValidation')]
#[CoversMethod(HasValidator::class, 'forceCreateWithValidation')]
#[CoversMethod(HasValidator::class, 'forceCreateQuietlyWithValidation')]
#[CoversMethod(HasValidator::class, 'makeWithValidation')]
#[CoversMethod(HasValidator::class, 'firstOrNewWithValidation')]
#[CoversMethod(HasValidator::class, 'firstOrCreateWithValidation')]
#[CoversMethod(HasValidator::class, 'createOrFirstWithValidation')]
#[CoversMethod(HasValidator::class, 'updateOrCreateWithValidation')]
#[CoversMethod(HasValidator::class, 'incrementOrCreateWithValidation')]
class CreateTest extends FeatureTestCase
{
    use DatabaseMigrations;

    protected bool $fakeProduct = false;

    /**
     * @throws ModelValidatorNotFound
     * @throws ModelNotValidated
     */
    #[TestWith(['createWithValidation'])]
    #[TestWith(['createQuietlyWithValidation'])]
    #[TestWith(['forceCreateWithValidation'])]
    #[TestWith(['forceCreateQuietlyWithValidation'])]
    #[TestWith(['makeWithValidation'])]
    #[TestWith(['firstOrNewWithValidation'])]
    #[TestWith(['firstOrCreateWithValidation'])]
    #[TestWith(['createOrFirstWithValidation'])]
    #[TestWith(['updateOrCreateWithValidation'])]
    #[TestWith(['incrementOrCreateWithValidation'])]
    #[TestDox('Method $method threw exception')]
    public function test_create_exception(string $method): void
    {
        $data = Product::factory()->make(['name' => null])->toArray();
        $this->expectException(ModelNotValidated::class);
        Product::$method($data);
    }

    /**
     * @throws ModelValidatorNotFound
     * @throws ModelNotValidated
     */
    public function test_increment_or_create_success(): void
    {
        $data = Product::factory()->make()->toArray();
        $product = Product::incrementOrCreateWithValidation($data);
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => $data['name'],
            'price' => $data['price'],
            'total' => $data['total'],
            'count' => 1,
        ]);
        Product::incrementOrCreateWithValidation($data);
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => $data['name'],
            'price' => $data['price'],
            'total' => $data['total'],
            'count' => 2,
        ]);
    }

    /**
     * @throws ModelValidatorNotFound
     * @throws ModelNotValidated
     */
    #[TestWith(['firstOrCreateWithValidation'])]
    #[TestWith(['createOrFirstWithValidation'])]
    #[TestWith(['updateOrCreateWithValidation'])]
    #[TestDox('Method $method id ok')]
    public function test_dual_methods_success(string $method): void
    {
        $data = Product::factory()->make()->toArray();
        unset($data['total']);
        $product = Product::$method($data, ['total' => 42]);
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => $data['name'],
            'price' => $data['price'],
            'total' => 42,
        ]);

        $product = Product::$method($data, ['total' => 43]);
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => $data['name'],
            'price' => $data['price'],
            'total' => $method === 'updateOrCreateWithValidation' ? 43 : 42,
        ]);
    }

    /**
     * @throws ModelValidatorNotFound
     * @throws ModelNotValidated
     */
    public function test_first_or_new_success(): void
    {
        $data = Product::factory()->make()->toArray();
        $model = Product::firstOrNewWithValidation($data);
        $this->assertInstanceOf(Product::class, $model);
    }

    /**
     * @throws ModelValidatorNotFound
     * @throws ModelNotValidated
     */
    public function test_make_success(): void
    {
        $data = Product::factory()->make()->toArray();
        $model = Product::makeWithValidation($data);
        $this->assertInstanceOf(Product::class, $model);
    }

    /**
     * @throws ModelValidatorNotFound
     * @throws ModelNotValidated
     */
    #[TestWith(['createWithValidation'])]
    #[TestWith(['createQuietlyWithValidation'])]
    #[TestWith(['forceCreateWithValidation'])]
    #[TestWith(['forceCreateQuietlyWithValidation'])]
    #[TestDox('Method $method id ok')]
    public function test_create_success(string $method): void
    {
        $data = Product::factory()->make()->toArray();
        Product::$method($data);
        $this->assertDatabaseHas('products', [
            'name' => $data['name'],
            'price' => $data['price'],
            'total' => $data['total'],
        ]);
    }
}