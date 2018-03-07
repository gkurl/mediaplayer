<?php

namespace App\Http\Controllers;



use App\User;
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
        /*$email = $request->session()->get('email')*/;


        $refreshToken = \App\User::pluck('refresh_token')->where('email', $request->session()->get('email'));


        if(empty($refreshToken->refresh_token))

        // Request a access token using the code from Spotify
        $session->requestAccessToken($_GET['code']);

        $accessToken = $session->getAccessToken();
        $refreshToken = $session->getRefreshToken();

        //Store access and refresh tokens in DB

        $insert = ['access_token' => $accessToken, 'refresh_token' => $refreshToken];

        \App\User::where('email', $request->session()->get('email'))->insert($insert)->first();


        //Do some checks to see if token is there or not to determine if already existing user

         if($refreshToken){

            $accessToken = \App\User::pluck('access_token')->where('email', $request->session()->get('email'))->first();

            //Check for timeout if logging in after long time, if so, get new access token

            try {
                $tryUrl->get("https://api.spotify.com/v1/me/top/",  ['headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $accessToken
                ],
            ]);

            } catch (\Exception $e){

                $session->refreshAccessToken($refreshToken);

                $accessToken = $session->getAccessToken();

                //Update access token in DB

                \App\User::where('email', $request->session()->get('email'))->update(['access_token' => $accessToken]);

            }

            $api->setAccessToken($accessToken);

        }

        return view('mystats')->with('api', $api);

        }




    }
