<?php

namespace YepBro\EloquentValidator\Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use PHPUnit\Framework\Attributes\CoversMethod;
use Workbench\App\Models\MainProduct;
use YepBro\EloquentValidator\Exceptions\ModelNotValidated;
use YepBro\EloquentValidator\HasValidator;

#[CoversMethod(HasValidator::class, 'bootHasValidator')]
class AutoValidationTest extends FeatureTestCase
{
    use DatabaseMigrations;

    public function test_create_success()
    {
        $data = MainProduct::factory()->make()->toArray();
        MainProduct::create($data);
        $this->assertDatabaseHas('products', $data);
    }

    public function test_create_exception()
    {
        $data = MainProduct::factory()->make()->toArray();
        $data['name'] = 'a';
        $this->expectException(ModelNotValidated::class);
        MainProduct::create($data);
    }

    public function test_update_success()
    {
        $product = MainProduct::factory()->create();
        $data = MainProduct::factory()->make()->toArray();
        $product->update($data);
        $this->assertDatabaseHas('products', $data + ['id' => $product->id]);
    }

    public function test_update_exception()
    {
        $data = MainProduct::factory()->make()->toArray();
        $product = MainProduct::create($data);
        $data['name'] = 'a';
        $this->expectException(ModelNotValidated::class);
        $product->update($data);
    }
}