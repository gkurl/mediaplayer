<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReturnStatsController extends Controller
{
    public function returnStats(\GuzzleHttp\Client $httpClient)
    {

        try{
          $response = $httpClient->get('https://api.spotify.com/v1/me',

              ['headers' => ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . session('token_access')]]);

        } catch (\Exception $e) {

            /*$refreshToken = $httpClient->post('https://accounts.spotify.com/api/token',
                ['form_params' =>
                    ['client_id' => env('SPOTIFY_KEY'),
                        'client_secret' => env('SPOTIFY_SECRET'),
                        'grant_type' => 'refresh_token',
                        'redirect_uri' => env('SPOTIFY_REDIRECT_URI')
                    ]
                ]);*/
        }




    }
}



        /*            $refreshToken = json_decode($refreshToken->getBody());*/


