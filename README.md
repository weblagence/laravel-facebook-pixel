# Facebook Pixel integration for Laravel

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

An easy Facebook Pixel implementation for your Laravel 5 application.

WebL'Agence is a french web agency based in Paris. You can find all our projects [on our website](https://weblagence.com).

## Facebook Pixel

The Facebook pixel is a snippet of JavaScript code that allows you to track visitor activity on your website. It works by loading a small library of functions which you can use whenever a site visitor takes an action (called an event) that you want to track (called a **conversion**). [Tracked conversions](https://developers.facebook.com/docs/facebook-pixel/implementation/conversion-tracking) appear in the [Facebook Ads Manager](https://www.facebook.com/adsmanager) and in the [Facebook Analytics](https://business.facebook.com/analytics) dashboard, where they can be used to measure the effectiveness of your ads, to define [custom audiences](https://developers.facebook.com/docs/facebook-pixel/implementation/custom-audiences) for ad targeting, for [dynamic ads](https://developers.facebook.com/docs/facebook-pixel/implementation/dynamic-ads) campaigns, and to analyze that effectiveness of your website's conversion funnels.

For concrete examples of what you want to send throught the [Standard Events](https://developers.facebook.com/docs/facebook-pixel/reference#events)

## Install

You can install the package via Composer:

```bash
composer require weblagence/laravel-facebook-pixel
```

In Laravel 5.5 and up, the package will automatically register the service provider and facade

In L5.4 or below start by registering the package's the service provider and facade:

```php
// config/app.php

'providers' => [
    ...
    WebLAgence\LaravelFacebookPixel\LaravelFacebookPixelServiceProvider::class,
],

'aliases' => [
    ...
    'LaravelFacebookPixel' => WebLAgence\LaravelFacebookPixel\LaravelFacebookPixelFacade::class,
],
```

Next, publish the config file:

```bash
php artisan vendor:publish --provider="WebLAgence\LaravelFacebookPixel\LaravelFacebookPixelServiceProvider"
```

## Configuration

The configuration file is fairly simple.

```php
return [

    /*
     * The Facebook Pixel id, should be a code that looks something like "XXXXXXXXXXXXXXXX".
     */
    'facebook_pixel_id' => '',
   
];

```

## Usage

### Basic Example

First you'll need to include Facebook Pixel's script. Facebook's docs recommend doing this right after the body tag.

```
{{-- layout.blade.php --}}
<html>
  <head>
    {!! FacebookPixel::headContent() !!}
    {{-- ... --}}
  </head>
  <body>
    {!! FacebookPixel::bodyContent() !!}
    {{-- ... --}}
  </body>
</html>
```

### Send pixel

At any moment, you can use the `createEvent($eventName, $parameters = [])` function to create a [Standard Event](https://developers.facebook.com/docs/facebook-pixel/reference#events)

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email jeremy@weblagence.com instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
