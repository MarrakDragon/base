<?php

namespace App\Helpers;

class OpenLibraryAPI
{

    protected $baseUrl =         "http://covers.openlibrary.org/b/ISBN/";

    function __construct()
    { }

    public function get($isbn13, $size)
    {

        error_log('getting cover for -> ' . $isbn13);
        $constructedURL = $this->baseUrl . $isbn13 . '-' . $size . '.jpg?default=false';

        $retVal = $this->getJson($constructedURL);
        if ($retVal) {
            //$results = collect($retVal);
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
