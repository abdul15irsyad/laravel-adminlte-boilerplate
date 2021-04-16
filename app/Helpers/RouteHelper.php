<?php
namespace App\Helpers;
 
use Route;
 
class RouteHelper {
    public static function set_parameters($name,$value) {
        Route::current()->setParameter($name,$value);
        return Route::current()->parameters();
    }
}