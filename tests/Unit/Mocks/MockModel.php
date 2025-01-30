<?php
declare(strict_types=1);

namespace YepBro\EloquentValidator\Tests\Unit\Mocks;

use Illuminate\Database\Eloquent\Model;
use YepBro\EloquentValidator\HasValidator;

class MockModel extends Model
{
    use MagicalAccessTrait, HasValidator;

    protected $guarded = [];

    public function testIsValidatorInit(): bool
    {
        return isset($this->validator);
    }
}