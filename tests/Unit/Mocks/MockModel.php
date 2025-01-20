<?php

namespace YepBro\EloquentValidator\Tests\Unit\Mocks;

use Illuminate\Database\Eloquent\Model;
use YepBro\EloquentValidator\HasValidator;

class MockModel extends Model
{
    use MagicalAccessTrait, HasValidator;

    public function magicSetOriginal(array $original): void
    {
        $this->original = $original;
    }

    public function magicGetOriginals(): array
    {
        return $this->original;
    }

    public function magicAddOriginal(string $key, mixed $value): void
    {
        $this->original[$key] = $value;
    }
}