<?php

namespace Workbench\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Workbench\App\Models\MainProduct;

class MainProductFactory extends Factory
{
    protected $model = MainProduct::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'price' => fake()->randomFloat(2, 1, 999),
            'total' => fake()->numberBetween(0, 500),
            'is_top' => fake()->boolean(),
        ];
    }
}
