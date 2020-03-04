<?php

namespace WebLAgence\LaravelFacebookPixel;

use Illuminate\View\View;

/**
 * Class ScriptViewCreator
 * @package WebLAgence\LaravelFacebookPixel
 */
class ScriptViewCreator
{
    /**
     * @var LaravelFacebookPixel
     */
    protected $laravelFacebookPixel;
    
    /**
     * ScriptViewCreator constructor.
     * @param LaravelFacebookPixel $laravelFacebookPixel
     */
    public function __construct(LaravelFacebookPixel $laravelFacebookPixel)
    {
        $this->laravelFacebookPixel = $laravelFacebookPixel;
    }
    
    /**
     * @param View $view
     */
    public function create(View $view)
    {
        $view->with('enabled', $this->laravelFacebookPixel->isEnabled())
            ->with('nonce', $this->laravelFacebookPixel->getCspNonceCallback())
            ->with('id', $this->laravelFacebookPixel->id());
    }
}