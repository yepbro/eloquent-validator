<?php

namespace Workbench\App\Validators;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\ValidationRule;
use YepBro\EloquentValidator\ModelValidator;

class RuleModelValidator extends ModelValidator
{
    /** @var array<string, string|array<int, string|Rule|ValidationRule>> */
    protected array $rules = [
        //
    ];
}