<?php
/**
 * Created by PhpStorm.
 * User: dongyuxiang
 * Date: 16/01/2018
 * Time: 17:03
 */

namespace db;


use Illuminate\Support\ServiceProvider;

class DbServiceProvider extends ServiceProvider
{
    /**
     * Application bootstrap event.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/m2ez-db.php' => config_path('m2ez-db.php'),
        ], 'config');
    }
    /**
     * Register the service provider.
     */
    public function register()
    {
        //
    }
}