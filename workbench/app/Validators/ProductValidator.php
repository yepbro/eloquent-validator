<?php

namespace Workbench\App\Validators;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\ValidationRule;
use YepBro\EloquentValidator\ModelValidator;

class ProductValidator extends ModelValidator
{
    /** @var array<string, string|array<int, string|Rule|ValidationRule>> */
    protected array $rules = [
        'name' => 'required|string|min:3',
        'price' => ['required', 'numeric'],
        'total' => ['required', 'integer'],
        'is_top' => 'boolean',
    ];

    /** @var array<string, string> */
    protected array $messages = [
        'name.required' => ':attribute is mandatory.',
    ];

    /** @var array<string, string> */
    protected array $attributes = [
        'name' => 'Product name',
    ];
}