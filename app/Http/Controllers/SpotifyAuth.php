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

        if(Auth::check()){

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

        return view('auth.login');





        /*    $existingRefreshToken = \App\User::select('refresh_token')->where('email', $request->get('email'))->first();

            $client_id = env('SPOTIFY_KEY');
            $client_secret = env('SPOTIFY_SECRET');
            $redirect_uri = env('SPOTIFY_REDIRECT_URI');

            //instantiate session for Spotify web API

            $session = new SpotifyWebAPI\Session(

                $client_id,
                $client_secret,
                $redirect_uri
            );

            \App\User::select('access_token')->where('refresh_token');
            $session->refreshAccessToken($existingRefreshToken);

            return view('mystats');*/


        }

    public function retrieveTokens(Request $request)

    {
        $refreshToken = \App\User::select('refresh_token')->where('email', $request->get('email'))->first();


        if(!$refreshToken) {

            redirect('/login/spotify');
        }}

     /*   } elseif (isset($refreshToken)){

            $session = new SpotifyWebAPI\Session(

                $client_id = env('SPOTIFY_KEY'),
                $client_secret = env('SPOTIFY_SECRET'),
                $redirect_url = env('SPOTIFY_REDIRECT_URI')
            );


            $newAccessToken = $session->refreshAccessToken($refreshToken);

            \App\User::where('refresh_token', $refreshToken)->update(['refresh_token' => $newAccessToken]);
        }


        return view('mystats');*/


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
