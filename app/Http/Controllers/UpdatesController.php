<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;

class UpdatesController extends Controller
{
    public function httpPool()
    {
        /**
         * Starts Http Get
         **/
        $startHttpGet = now();
        $urls = [
            'https://reqres.in/api/users/2',
            'https://reqres.in/api/users/3',
            'https://reqres.in/api/users/4',
        ];
        foreach ($urls as $url) {
            $httpGetResponse = Http::get($url);
            dump($httpGetResponse->json());
        }

        dump('httpGetResponse : '.now()->diffInMilliseconds($startHttpGet).'ms');

        /**
         * Starts Http Pool
         **/
        $startHttpPool = now();
        $httpPoolResponses = Http::pool(fn (Pool $pool) => [
            $pool->get('https://reqres.in/api/users/2'),
            $pool->get('https://reqres.in/api/users/3'),
            $pool->get('https://reqres.in/api/users/4'),
        ]);

        foreach ($httpPoolResponses as $response) {
            dump($response->json());
        }
        dump('httpPoolResponses : '.now()->diffInMilliseconds($startHttpPool).'ms');
    }
}
