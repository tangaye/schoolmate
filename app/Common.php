<?php

namespace App;
use Carbon\Carbon;

/**
 * This is class will hold methods or properties that are common to most models
 */
class Common
{
   	public static function genders()
    {
        return [
            "Male", 
            "Female"
        ];
    }

    // this get the current date
    public static function date() {
        return Carbon::now();
    }
}
