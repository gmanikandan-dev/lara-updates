<?php

use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/http-pool', function () {
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

    dump(now()->diffInMilliseconds($startHttpGet));

    $startHttpPool = now();
    $httpPoolResponses = Http::pool(fn (Pool $pool) => [
        $pool->get('https://reqres.in/api/users/2'),
        $pool->get('https://reqres.in/api/users/3'),
        $pool->get('https://reqres.in/api/users/4'),
    ]);

    foreach ($httpPoolResponses as $response) {
        dump($response->json());
    }
    dump(now()->diffInMilliseconds($startHttpPool), $httpPoolResponses);
});
