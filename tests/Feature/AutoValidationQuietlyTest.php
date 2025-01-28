<?php

namespace YepBro\EloquentValidator\Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use PHPUnit\Framework\Attributes\CoversMethod;
use Workbench\App\Models\MainProduct;
use YepBro\EloquentValidator\Exceptions\ModelNotValidated;
use YepBro\EloquentValidator\Exceptions\ModelValidatorNotFound;
use YepBro\EloquentValidator\HasValidator;

#[CoversMethod(HasValidator::class, 'saveQuietly')]
#[CoversMethod(HasValidator::class, 'updateQuietly')]
#[CoversMethod(HasValidator::class, 'createQuietly')]
#[CoversMethod(HasValidator::class, 'forceCreateQuietly')]
class AutoValidationQuietlyTest extends FeatureTestCase
{
    use DatabaseMigrations;

    public function test_save_success()
    {
        $product = MainProduct::factory()->create();
        $data = MainProduct::factory()->make()->toArray();
        $product->fill($data)->saveQuietly();
        $this->assertDatabaseHas('products', $data + ['id' => $product->id]);
    }

    /**
     * @throws ModelValidatorNotFound
     */
    public function test_save_exception()
    {
        $data = MainProduct::factory()->make()->toArray();
        $product = MainProduct::create($data);
        $data['name'] = 'a';
        $this->expectException(ModelNotValidated::class);
        $product->fill($data)->saveQuietly();
    }

    public function test_update_success()
    {
        $product = MainProduct::factory()->create();
        $data = MainProduct::factory()->make()->toArray();
        $product->updateQuietly($data);
        $this->assertDatabaseHas('products', $data + ['id' => $product->id]);
    }

    public function test_update_exception()
    {
        $data = MainProduct::factory()->make()->toArray();
        $product = MainProduct::create($data);
        $data['name'] = 'a';
        $this->expectException(ModelNotValidated::class);
        $product->updateQuietly($data);
    }

    /**
     * @throws ModelValidatorNotFound
     * @throws ModelNotValidated
     */
    public function test_create_success()
    {
        $data = MainProduct::factory()->make()->toArray();
        MainProduct::createQuietly($data);
        $this->assertDatabaseHas('products', $data);
    }

    /**
     * @throws ModelValidatorNotFound
     */
    public function test_create_exception()
    {
        $data = MainProduct::factory()->make()->toArray();
        $data['name'] = 'a';
        $this->expectException(ModelNotValidated::class);
        MainProduct::createQuietly($data);
    }

    /**
     * @throws ModelValidatorNotFound
     * @throws ModelNotValidated
     */
    public function test_force_create_success()
    {
        $data = MainProduct::factory()->make()->toArray();
        MainProduct::forceCreateQuietly($data);
        $this->assertDatabaseHas('products', $data);
    }

    /**
     * @throws ModelValidatorNotFound
     */
    public function test_force_create_exception()
    {
        $data = MainProduct::factory()->make()->toArray();
        $data['name'] = 'a';
        $this->expectException(ModelNotValidated::class);
        MainProduct::forceCreateQuietly($data);
    }
}