<?php

namespace Uibar\Gravatar;

use Illuminate\Support\ServiceProvider;

class GravatarServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerGravatar();
    }

    /**
     * Register the Gravatar class.
     *
     * @return void
     */
    private function registerGravatar()
    {
        $this->app->singleton('gravatar', function($app){
            return new Gravatar;
        });
    }
}