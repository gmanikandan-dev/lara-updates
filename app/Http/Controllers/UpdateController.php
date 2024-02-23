<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;

class UpdateController extends Controller
{
    public function index()
    {
        $users = User::select('name', 'email', 'created_at', 'updated_at')
            ->get();

        return view('user.index', compact('users'));
    }

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
    public function useWhereIntegerInRaw()
    {
        /**
         *  26MB, 350-400ms
         */
        // $users = User::whereIn('id', range(1,5000))->get();

        /**
         *  25MB, 250-290ms
         */
        // $users = User::whereIntegerInRaw('id', range(1,5000))->get();

        /**
         *  24MB, 240-270ms
         */
        // $users = User::select('name','email','created_at', 'updated_at')
        //             ->whereIntegerInRaw('id', range(1,5000))->get();

        /**
         *  25MB, 240-260ms
         */
        // $users = User::find(range(1,5000));

        /**
         *  24MB, 240-250ms
         */
        $users = User::select('name', 'email', 'created_at', 'updated_at')
            // ->find(range(1, 5000));
                ->get();

        return view('user.index', compact('users'));
    }

    /**
     * Use chunkById() intead of chunk()
     */
    public function useChunkById()
    {
        User::whereNull('email_verified_at')
            ->chunk(2, function ($users) {
                foreach ($users as $user) {
                    $user->email_verified_at = now();
                    $user->save();
                }
            });

        return redirect('user');
    }
}
