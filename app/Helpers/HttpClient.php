<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class HttpClient 
{
    static function fetch($method, $url, $body = [], $files = [])
    {
        // jika method get, langsung return response apabila memang ada response dari url atau api yg di hit tersebut
        if($method == 'GET') return Http::timeout(1)->get($url)->json();

        // jika terdapat file, client berupa multipart
        if(sizeof($files) > 0) {
            $client = Http::asMultipart();

            // attach file pada client
            foreach ($files as $key => $file) {
                $path = $file->getPathName();
                $name = $file->getClientOriginalName();
                // attach file
                $client->attach($key, file_get_contents($path), $name);
            }

            // fetch api
            return $client->post($url, $body)->json();

        }

        // fetch post
        return Http::post($url, $body)->json();
        
    } 

}