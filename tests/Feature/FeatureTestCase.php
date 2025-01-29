<?php

namespace YepBro\EloquentValidator\Tests\Feature;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Workbench\App\Models\Product;
use Workbench\App\Models\RuleModel;
use YepBro\EloquentValidator\EloquentValidatorServiceProvider;

class FeatureTestCase extends \Orchestra\Testbench\TestCase
{
    use WithWorkbench;

    protected Product $product;

    protected bool $fakeProduct = false;

    protected function setUp(): void
    {
        parent::setUp();
        if ($this->fakeProduct) {
            $this->product = $this->getProduct();
        }
    }

    protected function getProduct(array $attributes = []): Product
    {
        return Product::factory()->create($attributes);
    }

    public function getRuleModel(mixed $value): RuleModel
    {
        return new RuleModel(['field' => $value]);
    }

    /**
     * Get package providers.
     *
     * @param Application $app
     * @return array<int, class-string<ServiceProvider>>
     */
    protected function getPackageProviders($app): array
    {
        return [
            EloquentValidatorServiceProvider::class,
        ];
    }
}