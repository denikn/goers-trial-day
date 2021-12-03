<?php

namespace App\Helpers;

class ConstantHelper
{
    /**
     * Order number generator
     *
     * @param  string $file
     * @param  string $dir
     * @return object
     **/
    public static function gender($gender)
    {
		switch($gender)
		{
			case 0 : return 'MALE';
			break;
			case 1 : return 'FEMALE';
			break;
		}
    }
}

