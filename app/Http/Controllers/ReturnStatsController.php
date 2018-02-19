<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SpotifyWebAPI;

class ReturnStatsController extends Controller
{
    public function returnStats(\GuzzleHttp\Client $httpClient)

    {



    }
}




            /*$response = $httpClient->get('https://api.spotify.com/v1/me/top/', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('access_token'),
                ],
            ]);
            return response()->json(json_decode($response->getBody())->items);*/





