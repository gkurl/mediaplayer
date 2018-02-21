<?php

namespace App\Http\Controllers;


use App\Tokens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SpotifyWebAPI;
use GuzzleHttp\Client;


class SpotifyAuth extends Controller
{

    public function spotifyLogin(){

            //set required params for spotify api from env file.

            $client_id = env('SPOTIFY_KEY');
            $client_secret = env('SPOTIFY_SECRET');
            $redirect_uri = env('SPOTIFY_REDIRECT_URI');

            $session = new SpotifyWebAPI\Session(

                $client_id,
                $client_secret,
                $redirect_uri
            );

            //Define scopes for access

            $options = ['scope' => ['user-top-read', 'playlist-read-private', 'user-read-private']];

            //Redirect to authorisation page.

            return redirect($session->getAuthorizeUrl($options));


    }

    public function retrieveTokens()
    {

        if(!Auth::check()){
            redirect('register');
        }

        $session = new SpotifyWebAPI\Session(

            $client_id = env('SPOTIFY_KEY'),
            $client_secret = env('SPOTIFY_SECRET'),
            $redirect_url = env('SPOTIFY_REDIRECT_URI')
        );

        //Request access token from Spotify


        $session->requestAccessToken($_GET['code']);

        $accessToken = $session->getAccessToken();
        $refreshToken = $session->getRefreshToken();

        //Store access and refresh tokens in DB





        return view('mystats')->with(session()->all());
    }

   /* public function apiWrapper(){

        $api = new SpotifyWebAPI\SpotifyWebAPI();

        //Fetch saved access tokens

        $accessToken = \App\Tokens::where('access_token')->first();


        $api->setAccessToken($accessToken);


    }*/




        public function denied()
        {

            return view('denied');
        }


    }
