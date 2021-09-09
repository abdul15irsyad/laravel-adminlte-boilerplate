<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        require_once app_path() . '/Helpers/TokenHelper.php';
        require_once app_path() . '/Helpers/TitleHelper.php';
        require_once app_path() . '/Helpers/ButtonHelper.php';
        require_once app_path() . '/Helpers/MailHelper.php';
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
