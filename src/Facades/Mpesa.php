<?php

namespace Ekale\LaravelMpesa\Facades;

use Illuminate\Support\Facades\Facade;

class Mpesa extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'mpesa';
    }
}