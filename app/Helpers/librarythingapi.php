<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class LibraryThingAPI
{
    protected $baseUrl =  "http: //covers.librarything.com/devkey/";

    function __construct()
    { }

    public function get($isbn13, $size)
    {

        error_log('getting cover for -> ' . $isbn13);
        $constructedURL = $this->baseUrl . $this->key . '/' . $size . '/isbn/' . $isbn13;

        $retVal = $this->getJson($constructedURL);
        // @todo Check results for a 1x1 pixel. that means it's missing.
        if ($retVal) {
            return ($constructedURL);
        }


        return false;
    }

    protected function getJson($url)
    {
        // Returns false if the request fails (as like a 404)
        $response = @file_get_contents($url, false);
        if ($response != false)
            return true; // In this case, we're just checking for existence

        return false;
    }
}
