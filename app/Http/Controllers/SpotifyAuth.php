<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

use Laravel\Socialite\Facades\Socialite;

class SpotifyAuth extends Controller
{
    public function spotifyLogin(){

        return Socialite::with('spotify')->redirect();

    }

    public function spotifyCallback(\GuzzleHttp\Client $httpClient){

        if(isset($_GET['error'])){

            return redirect('/denied');

        }

       /* $response = $httpClient->post('https://accounts.spotify.com/authorize',
            ['form_params' =>
            ['client_id'=>env('SPOTIFY_CLIENT_ID'),
                'client_secret' => env('SPOTIFY_CLIENT_SECRET'),
                'grant_type'=>'authorization_code',
                'code' => $_GET['code'],
                'redirect_uri'=>env('REDIRECT_URI')

                        ]
                 ]);*/
    }

    public function denied(){
        return view('denied');
    }
}
