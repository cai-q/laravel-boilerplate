<?php

namespace App\Providers;

use App\Core\ThirdPartyWrapper\Wechat\WechatApplication;
use App\User;
use Illuminate\Support\ServiceProvider;

class WechatServiceProvider extends ServiceProvider
{
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(WechatApplication::class, function () {
            return new WechatApplication();
        });
    }
}
