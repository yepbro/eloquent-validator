<?php

namespace YepBro\EloquentValidator\Tests\Mocks;

use Illuminate\Database\Eloquent\Model;
use YepBro\EloquentValidator\HasValidator;

class MockModel extends Model
{
    use CallProtectedMethods, HasValidator;
}