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

    /**
     * @throws ModelValidatorNotFound
     * @throws ModelNotValidated
     */
    #[TestWith(['createWithValidation'])]
    #[TestWith(['createQuietlyWithValidation'])]
    #[TestWith(['forceCreateWithValidation'])]
    #[TestWith(['forceCreateQuietlyWithValidation'])]
    #[TestDox('Method $method threw exception')]
    public function test_create_exception(string $method): void
    {
        $data = Product::factory()->make(['name' => null])->toArray();
        $this->expectException(ModelNotValidated::class);
        Product::$method($data);
    }
}