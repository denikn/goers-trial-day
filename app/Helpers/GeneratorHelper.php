<?php

namespace App\Helpers;
use Illuminate\Support\Str;

class GeneratorHelper
{
    /**
     * Order number generator
     *
     * @param  string $file
     * @param  string $dir
     * @return object
     **/
    public static function orderNumber()
    {
		return rand(10000, 99999) . '-' . Str::random(5) . '-' . rand(111, 999);
    }
}

