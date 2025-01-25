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

    protected $table = 'products';

    public $validatorClass = ProductValidator::class;

    protected $fillable = [
        'name',
        'price',
        'total',
        'advantages',
        'is_top',
    ];

    protected $casts = [
        'is_top' => 'boolean',
        'price' => 'decimal:2',
        'advantages' => 'array',
    ];
}