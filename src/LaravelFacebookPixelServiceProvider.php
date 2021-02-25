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
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'facebook-pixel');
    
        $this->publishes([
            __DIR__.'/../resources/config/facebook-pixel.php' => config_path('facebook-pixel.php'),
        ], 'config');
        
        $this->app['view']->creator(
            ['facebook-pixel::head', 'facebook-pixel::body'],
            'WebLAgence\LaravelFacebookPixel\ScriptViewCreator'
        );
    }
    
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../resources/config/facebook-pixel.php', 'facebook-pixel');
        
        $id = !empty(config('facebook-pixel.facebook_pixel_ids')) ? config('facebook-pixel.facebook_pixel_ids') : [config('facebook-pixel.facebook_pixel_id')];
        
        $laravelFacebookPixel = new LaravelFacebookPixel($id);
        $laravelFacebookPixel->addCspNonce(config('facebook-pixel.csp_callback'));
        if (config('facebook-pixel.enabled') === false) {
            $laravelFacebookPixel->disable();
        }
        
        $this->app->instance('WebLAgence\LaravelFacebookPixel\LaravelFacebookPixel', $laravelFacebookPixel);
        $this->app->alias(LaravelFacebookPixel::class, 'facebook-pixel');
    }
}