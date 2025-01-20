<?php

namespace YepBro\EloquentValidator\Tests\Unit\Mocks;

trait MagicalAccessTrait
{
    public function magicSetProperty(string $property, mixed $value): void
    {
        $this->{$property} = $value;
    }

    public function magicGetProperty(string $property): mixed
    {
        return $this->{$property};
    }

    public function magicCallMethod(string $method, ...$arguments): mixed
    {
        return $this->{$method}(...$arguments);
    }
}