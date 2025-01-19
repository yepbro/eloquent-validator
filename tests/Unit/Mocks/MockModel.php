<?php

namespace YepBro\EloquentValidator\Tests\Unit\Mocks;

use Illuminate\Database\Eloquent\Model;
use YepBro\EloquentValidator\HasValidator;

class MockModel extends Model
{
    use CallProtectedMethods, HasValidator;
}