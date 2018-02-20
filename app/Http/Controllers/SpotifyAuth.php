<?php

namespace App\Http\Controllers;


use App\Tokens;
use Illuminate\Http\Request;
use SpotifyWebAPI;


class SpotifyAuth extends Controller
{

    public function spotifyLogin()
    {


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

    public function retrieveTokens(){

        $session = new SpotifyWebAPI\Session(

            $client_id = env('SPOTIFY_KEY'),
            $client_secret = env('SPOTIFY_SECRET'),
            $redirect_url = env('SPOTIFY_REDIRECT_URI')
        );

        //Request access token from Spotify

        $session->requestAccessToken($_GET['code']);

        $accessToken = $session->getAccessToken();
        $refreshToken = $session->getRefreshToken();

        //Request refresh token from Spotify

        $session->refreshAccessToken($refreshToken);

        //Store access and refresh tokens in DB

        $token = new Tokens;
        $token->access_token = $accessToken;
        $token->refresh_token = $refreshToken;
        $token->save();

        //Check for access token time out and if timed out, obtain new code


        return view('mystats');

    }


    public function denied(){

        return view('denied');
    }


}
