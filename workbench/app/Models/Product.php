<?php

namespace Workbench\App\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Workbench\App\Validators\ProductValidator;
use Workbench\Database\Factories\ProductFactory;
use YepBro\EloquentValidator\HasValidator;

#[UseFactory(ProductFactory::class)]
class Product extends Model
{
    use HasFactory, HasValidator;

    public string $validatorClass = ProductValidator::class;

    protected $table = 'products';

    protected $guarded = [];

    protected $casts = [
        'is_top' => 'boolean',
        'price' => 'decimal:2',
    ];
}