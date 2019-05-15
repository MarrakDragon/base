<?php
namespace App\Helpers;

class UpciteAPI
{
    protected $baseUrl =  "https://api.upcitemdb.com/prod/trial/";

    public function get($upccode)
    {
        // $result = collect($this->getJson($this->url . 'lookup?upc==' . $upccode));
        // return ($result);

        error_log('getting data for -> ' . $upccode);
        $constructedURL = $this->baseUrl . 'lookup?upc=' . $upccode;

        $retVal = $this->getJson($constructedURL);
        // @todo Check results for a 1x1 pixel. that means it's missing.
        if ($retVal) {
            return ($retVal);
        }

        return false;
    }

    protected function getJson($url)
    {
        // Returns false if the request fails (as like a 404)
        $response = @file_get_contents($url, false);
        if ($response != false)
            return json_decode($response); // Make sure something's there

        return false;
    }
}
