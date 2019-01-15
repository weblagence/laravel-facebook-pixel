<?php

namespace WebLAgence\LaravelFacebookPixel;

use Illuminate\Support\ServiceProvider;

/**
 * Class LaravelFacebookPixelServiceProvider
 * @package WebLAgence\LaravelFacebookPixel
 */
class LaravelFacebookPixelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/facebook-pixel.php' => config_path('facebook-pixel.php'),
        ], "facebook-pixel");
    }
    
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/facebook-pixel.php', 'facebook-pixel');
        
        $laravelFacebookPixel = new LaravelFacebookPixel(config('facebook-pixel.id'));
        
        if (config('facebook-pixel.enabled') === false) {
            $laravelFacebookPixel->disable();
        }
        
        
        $this->app->instance('WebLAgence\LaravelFacebookPixel\LaravelFacebookPixel', $laravelFacebookPixel);
        $this->app->alias(LaravelFacebookPixel::class, 'facebook-pixel');
    }
}