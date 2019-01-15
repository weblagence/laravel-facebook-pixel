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
     * LaravelFacebookPixel constructor.
     * @param $config
     */
    public function __construct($id)
    {
        $this->id = $id;
        $this->enabled = true;
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
    public function headContent()
    {
        return "<!-- Facebook Pixel Code -->
        <script>
            !function(f,b,e,v,n,t,s)
              {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
                  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
                  n.queue=[];t=b.createElement(e);t.async=!0;
                  t.src=v;s=b.getElementsByTagName(e)[0];
                  s.parentNode.insertBefore(t,s)}(window, document,'script',
              'https://connect.facebook.net/en_US/fbevents.js');
              fbq('init', '" . $this->id . "');
              fbq('track', 'PageView');
            </script>
            <noscript><img height='1' width='1' style='display:none'
            src='https://www.facebook.com/tr?id=" . $this->id . "&ev=PageView&noscript=1'
            /></noscript>
            <!-- End Facebook Pixel Code -->";
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