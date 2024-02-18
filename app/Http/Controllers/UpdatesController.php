<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;

class UpdatesController extends Controller
{
    /**
     * Http pool fater by 50%
     */
    public function httpPool()
    {
        /**
         * Starts Http Get
         */
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
         */
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

    /**
     * Don't use whereIn().Use whereIntegerInRow() faster by 90%
     */
    public function useWhereIntegerInRow() 
    {
        $users = User::whereIn('id', range(1,10000))->get();

        return view('user.index', compact('users'));
    }
}
