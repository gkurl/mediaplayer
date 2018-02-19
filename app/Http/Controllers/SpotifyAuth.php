<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use SpotifyWebAPI;
use Laravel\Socialite\Facades\Socialite;


class SpotifyAuth extends Controller
{

    public function spotifyLogin()
    {
        //set required params for spotify api from env file.

        $client_id= env('SPOTIFY_KEY');
        $client_secret= env('SPOTIFY_SECRET');
        $redirect_uri= env('SPOTIFY_REDIRECT_URI');

        $session = new SpotifyWebAPI\Session(

            $client_id,
            $client_secret,
            $redirect_uri
        );

        //Redirect to authorisation page.

        header('Location: ' . $session->getAuthorizeUrl());

    }

    public function retrieveTokens(){

        $session = new SpotifyWebAPI\Session(

            $client_id = env('SPOTIFY_KEY'),
            $client_secret = env('SPOTIFY_SECRET'),
            $redirect_url = env('SPOTIFY_REDIRECT_URI')
        );

        //Request access token from Spotify

        $session->requestAccessToken($_GET['code']);

        $accessToken = $session->getAccessToken();

        //Store access token in DB

    }


    public function denied(){

        return view('denied');
    }


}
