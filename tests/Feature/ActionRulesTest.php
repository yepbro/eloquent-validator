<?php

namespace YepBro\EloquentValidator\Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use PHPUnit\Framework\Attributes\CoversMethod;
use Workbench\App\Models\Product;
use YepBro\EloquentValidator\Exceptions\ModelNotValidated;
use YepBro\EloquentValidator\Exceptions\ModelValidatorNotFound;
use YepBro\EloquentValidator\HasValidator;

#[CoversMethod(HasValidator::class, 'validate')]
class ActionRulesTest extends FeatureTestCase
{
    use DatabaseMigrations;

    /**
     * @throws ModelValidatorNotFound
     * @throws ModelNotValidated
     */
    public function test_update_rules(): void
    {
        $product = Product::factory()->create();
        $product->fill(['name' => 'test12'])->validate();

        $product->getModelValidatorInstance()->setUpdateRules([
            'name' => 'required|string|min:3|max:5',
        ]);
        $this->expectException(ModelNotValidated::class);
        $product->fill(['name' => 'test34'])->validate();
    }

    /**
     * @throws ModelValidatorNotFound
     * @throws ModelNotValidated
     */
    public function test_create_rules(): void
    {
        $product = Product::factory()->make();
        $product->fill(['name' => 'test12'])->validate();

        $product->getModelValidatorInstance()->setCreateRules([
            'name' => 'required|string|min:3|max:5',
        ]);
        $this->expectException(ModelNotValidated::class);
        $product->fill(['name' => 'test34'])->validate();
    }
}