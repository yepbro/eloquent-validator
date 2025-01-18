<?php

namespace YepBro\EloquentValidator\Tests\Mocks;

use YepBro\EloquentValidator\HasValidator;

class MockModel
{
    use CallProtectedMethods, HasValidator;
}