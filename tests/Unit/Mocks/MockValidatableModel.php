<?php
declare(strict_types=1);

namespace YepBro\EloquentValidator\Tests\Unit\Mocks;

use YepBro\EloquentValidator\HasValidator;
use YepBro\EloquentValidator\Validatable;

class MockValidatableModel extends MockModel implements Validatable
{
    use MagicalAccessTrait, HasValidator;

    protected $fillable = ['*'];
}