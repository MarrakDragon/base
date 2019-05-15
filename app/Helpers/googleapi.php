<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class GoogleAPI
{

    protected $client;

    protected $service;

    // set options for  request
    protected $optParams = ['langRestrict' => 'en'];

    function __construct()
    {
        /* Get config variables */
        $api_key = Config::get('google.key');
        error_log('Got key -> ' . $api_key);

        error_log('Creating client');
        $this->client = new \Google_Client();
        $this->client->setApplicationName("Your Application Name");
        //        $this->client->setDeveloperKey( $api_key );
        error_log('Setting key');
        $this->service = new \Google_Service_Books($this->client);
    }

    public function get($isbn13)
    {
        // LangRestrict options = af, ar, hy, bg, ca, zh-CN, zh-TW, hr, cs, da, nl, en, fil, fi,
        // fr, de, el, he, hu, is, id, it, ja, ko, lv, lt, ms, no, pl, pt-BR, pt-PT, ro, ru, sr, 
        // sk, sl, es, sv, tl, th, tr, uk, and vi.
        //
        // query options https://developers.google.com/books/docs/v1/using#q
        // https://developers.google.com/books/docs/v1/using#RetrievingVolume
        // https://developers.google.com/books/docs/v1/reference/volumes/get
        // https://developers.google.com/books/docs/v1/reference/volumes/list
        // https://developers.google.com/books/docs/v1/reference/volumes#method_books_volumes_list
        // 
        // query types:
        // https://github.com/googleapis/google-api-go-client/blob/master/books/v1/books-api.json
        // https://developers.google.com/books/docs/v1/using#st_params


        error_log('getting isbn13 -> ' . $isbn13);
        $results = $this->service->volumes->listVolumes($isbn13, $this->optParams);
        if (($results->totalItems) > 0) {
            $item = $results->items[0]->volumeInfo;
            $itemImages = $results->items[0]->volumeInfo->imageLinks;
            // If results are returned, just return the bits we care about in an array
            $returnResults = [
                'title' => $item->title,
                'authors' => implode(", ", $item->authors),
                'publisher' => $item->publisher,
                'published_date' => $item->publishedDate,
                'description' => $item->description,
                'page_count' => $item->pageCount,
                'url' => $item->selfLink,
                'language' => $item->language,
                'thumbnail' => $itemImages ? $itemImages->thumbnail : null,
                'large_image' => $itemImages ? $itemImages->large : null,
                'extraLarge_image' => $itemImages ? $itemImages->extraLarge : null,
            ];


            return ($returnResults);
        }
    }
}
