<?php
declare(strict_types=1);

namespace YepBro\EloquentValidator\Tests\Unit\Mocks;

use Illuminate\Database\Eloquent\Model;
use YepBro\EloquentValidator\HasValidator;

class MockModel extends Model
{
    use MagicalAccessTrait, HasValidator;

    public function magicAddOriginal(string $key, mixed $value): void
    {
        $this->original[$key] = $value;
    }
}