<?php
namespace App\Helpers;

class UpcDatabaseAPI
{
    protected $baseUrl =  "https://api.upcdatabase.org/product/"; // {id}/{api_key}

    protected $key = "27E89750BA837D37EBB369EB21F5D84F";

    public function get($upccode)
    {


        error_log('UpcDatabaseAPI: getting data for -> ' . $upccode);
        $constructedURL = $this->baseUrl .  '/' . $upccode . '/' . $this->key;

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
