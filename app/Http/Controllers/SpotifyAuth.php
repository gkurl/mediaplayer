<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

use Laravel\Socialite\Facades\Socialite;

class SpotifyAuth extends Controller
{
    public function spotifyLogin()
    {

        //Use Socialite to access Spotify authorisation

        return Socialite::with('spotify')->scopes(['user-top-read'])->redirect();

    }

    public function spotifyCallback(\GuzzleHttp\Client $httpClient)
    {

        //if user cancels or login fails return to a denied page
        if (isset($_GET['error'])) {

            return redirect('/denied');

        }

        //as per Spotify doc - once user has approved you must make post request to https://accounts.spotify.com/api/token to receive tokens

        $response = $httpClient->post('https://accounts.spotify.com/api/token',
            ['form_params' =>
                ['client_id' => env('SPOTIFY_KEY'),
                    'client_secret' => env('SPOTIFY_SECRET'),
                    'grant_type' => 'authorization_code',
                    'code' => $_GET['code'],
                    'redirect_uri' => env('SPOTIFY_REDIRECT_URI')
                ]
            ]);

        //Store returned tokens in Session


        /*session(['token_access' => json_decode($response->getBody())->access_token]);
        session(['token_refresh' => json_decode($response->getBody())->refresh_token]);*/

    }


    public function denied(){

        return view('denied');
    }


}
