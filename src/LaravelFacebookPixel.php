<?php

namespace WebLAgence\LaravelFacebookPixel;

use Illuminate\Support\Traits\Macroable;

/**
 * Class LaravelFacebookPixel
 * @package WebLAgence\LaravelFacebookPixel
 */
class LaravelFacebookPixel
{
    use Macroable;
    
    /**
     * @var string
     */
    protected $id;
    /**
     * @var string
     */
    protected $cspNonceCallback;

    /**
     * LaravelFacebookPixel constructor.
     * @param $id
     */
    public function __construct($id)
    {
        $this->id = $id;
        $this->enabled = true;
        $this->cspNonceCallback = '';
    }
    
    /**
     * Return the Facebook Pixel id.
     *
     * @return string
     */
    public function id()
    {
        return $this->id;
    }
    
    /**
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        
        return $this;
    }
    
    /**
     * Enable Facebook Pixel scripts rendering.
     */
    public function enable()
    {
        $this->enabled = true;
    }
    
    /**
     * Disable Facebook Pixel scripts rendering.
     */
    public function disable()
    {
        $this->enabled = false;
    }
    
    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @return string
     */
    public function getCspNonceCallback()
    {
        return $this->cspNonceCallback;
    }

    /**
     * @param string $callback
     */
    public function addCspNonce($callback)
    {
        if (!function_exists($callback)) {
            return;
        }
        $this->cspNonceCallback = $callback;
    }
    
    /**
     * @return string
     */
    public function bodyContent()
    {
        $facebookPixelSession = session()->pull('facebookPixelSession', []);
        $pixelCode = "";
        if (count($facebookPixelSession) > 0) {
            foreach ($facebookPixelSession as $key => $facebookPixel) {
                $pixelCode .= "fbq('track', '" . $facebookPixel["name"] . "', " . json_encode($facebookPixel["parameters"]) . ");";
            };
            session()->forget('facebookPixelSession');
            if($this->cspNonceCallback) {
                return "<script nonce='" . call_user_func($this->cspNonceCallback) . "'>" . $pixelCode . "</script>";
            }
            return "<script>" . $pixelCode . "</script>";
        }
        
        return "";
    }
    
    /**
     * @param $eventName
     * @param array $parameters
     */
    public function createEvent($eventName, $parameters = [])
    {
        $facebookPixelSession = session('facebookPixelSession');
        $facebookPixelSession = !$facebookPixelSession ? [] : $facebookPixelSession;
        $facebookPixel = [
            "name"       => $eventName,
            "parameters" => $parameters,
        ];
        array_push($facebookPixelSession, $facebookPixel);
        session(['facebookPixelSession' => $facebookPixelSession]);
    }
}