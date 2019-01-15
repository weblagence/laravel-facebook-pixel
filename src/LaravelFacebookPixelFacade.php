<?php

namespace WebLAgence\LaravelFacebookPixel;

use Illuminate\Support\Facades\Facade;

/**
 * Class LaravelFacebookPixelFacade
 * @package WebLAgence\LaravelFacebookPixel
 */
class LaravelFacebookPixelFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'facebook-pixel';
    }
}