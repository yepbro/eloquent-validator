<?php

namespace Workbench\App\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Workbench\App\Validators\ProductValidator;
use Workbench\App\Validators\RuleModelValidator;
use Workbench\Database\Factories\ProductFactory;
use YepBro\EloquentValidator\HasValidator;

class RuleModel extends Model
{
    use HasValidator;

    public string $validatorClass = RuleModelValidator::class;

    protected $table = 'products';

    protected $guarded = [];
}