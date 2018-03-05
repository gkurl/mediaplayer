<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SpotifyWebAPI;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;



class SpotifyAuth extends Controller
{

    public function spotifyLogin(){

            //set required params for spotify api from env file.

            $client_id = env('SPOTIFY_KEY');
            $client_secret = env('SPOTIFY_SECRET');
            $redirect_uri = env('SPOTIFY_REDIRECT_URI');

            //instantiate session for Spotify web API

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


    public function retrieveTokens(\GuzzleHttp\Client $tryUrl, Request $request)
    {
        //Start Spotify API session

        $client_id = env('SPOTIFY_KEY');
        $client_secret = env('SPOTIFY_SECRET');
        $redirect_uri = env('SPOTIFY_REDIRECT_URI');

        //instantiate session for Spotify web API

        $session = new SpotifyWebAPI\Session(

            $client_id,
            $client_secret,
            $redirect_uri
        );

        //Instantiate new API interface

        $api = new SpotifyWebAPI\SpotifyWebAPI();

        $refreshToken = \App\User::pluck('refresh_token')->where('email', $request->post('email'));

        if(empty($refreshToken->refresh_token))

        // Request a access token using the code from Spotify
        $session->requestAccessToken($_GET['code']);

        $accessToken = $session->getAccessToken();
        $refreshToken = $session->getRefreshToken();

        //Store access and refresh tokens in DB

        \App\User::where('email', $request->post('email')->insert(['access_token' => $accessToken, 'refresh_token' => $refreshToken]));

        //Do some checks to see if token is there or not to determine if already existing user


         if($refreshToken->refresh_token){

            $accessToken = \App\User::pluck('access_token')->where('email', $request->post('email'));

            //Check for timeout if logging in after long time, if so, get new access token

            try {
                $tryUrl->get("https://api.spotify.com/v1/me/top/",  ['headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $accessToken->access_token
                ],
            ]);

            } catch (\Exception $e){

                $session->refreshAccessToken($refreshToken->refresh_token);

                $accessToken = $session->getAccessToken();

                //Update access token in DB

                \App\User::where('email', $request->post('email')->update('access_token', $accessToken));

            }

            $api->setAccessToken($accessToken->access_token);

        }

        return view('mystats')->with('api', $api);

        }




    }
