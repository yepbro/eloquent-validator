<?php

namespace YepBro\EloquentValidator\Tests\Unit\Mocks;

trait CallProtectedMethods
{
    public function callMethod(string $method, ...$arguments): mixed
    {
        return $this->{$method}(...$arguments);
    }
}