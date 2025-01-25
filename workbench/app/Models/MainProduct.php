<?php

namespace Workbench\App\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Workbench\App\Validators\ProductValidator;
use Workbench\Database\Factories\MainProductFactory;
use YepBro\EloquentValidator\HasValidator;
use YepBro\EloquentValidator\Validatable;

#[UseFactory(MainProductFactory::class)]
class MainProduct extends Model implements Validatable
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