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

    public function spotifyLogin()
    {

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

        $options = [

            'scope' => ['user-top-read',
                'playlist-read-private',
                'user-read-private',
                'user-follow-read',
                'playlist-modify-public',
                'playlist-modify-private',]
        ];

        //Redirect to authorisation page.

        return redirect($session->getAuthorizeUrl($options));

    }


    public function retrieveTokens(Request $request)
    {

        //Instantiate API

        $api = new SpotifyWebAPI\SpotifyWebAPI();

        //Start Spotify API session

        $client_id = env('SPOTIFY_KEY');
        $client_secret = env('SPOTIFY_SECRET');
        $redirect_uri = env('SPOTIFY_REDIRECT_URI');

        //instantiate session for Spotify web API

        $session = new SpotifyWebAPI\Session(

            $client_id,
            $client_secret,
            $redirect_uri
        );/*$email = $request->session()->get('email')*/;


        $refreshToken = \App\User::where('email', $request->session()->get('email'))->pluck('refresh_token')->first();


        if (empty($refreshToken)) {

            // Request an access token using the code from Spotify
            $session->requestAccessToken($_GET['code']);

            $accessToken = $session->getAccessToken();
            $refreshToken = $session->getRefreshToken();

            //Store access and refresh tokens in DB


            \App\User::where('email', $request->session()->get('email'))->update(['access_token' => $accessToken, 'refresh_token' => $refreshToken]);
        }

        //Check for access token expiry via try-catch

          try{
               $api->setAccessToken($accessToken);

               $artists = object_get($api->getUserFollowedArtists(), 'artists.items');

           } catch (\Exception $e){
               $session = new \SpotifyWebAPI\Session($client_id, $client_secret, $redirect_uri);
               $session->refreshAccessToken($refreshToken);

               $accessToken = $session->getAccessToken();

               $api->setAccessToken($accessToken);

               \App\User::where('email', $request->session()->get('email'))->update(['access_token' => $accessToken]);


               $artists = object_get($api->getUserFollowedArtists(), 'artists.items');
           }


        // Fetch the saved access token from DB.

        $accessToken = \App\User::where('email', $request->session()->get('email'))->pluck('access_token')->first();

        if (empty($accessToken)) {

            $refreshToken = \App\User::where('email', $request->session()->get('email'))->pluck('refresh_token')->first();

            $session->refreshAccessToken($refreshToken);

            $accessToken = $session->getAccessToken();

            \App\User::where('email', $request->session()->get('email'))->update(['access_token' => $accessToken]);


        }

        if (http_response_code(401)) {

            // Fetch the refresh token from DB.

            $refreshToken = \App\User::where('email', $request->session()->get('email'))->pluck('refresh_token')->first();


            $session->refreshAccessToken($refreshToken);

            $accessToken = $session->getAccessToken();

            //Store access token in DB

            \App\User::where('email', $request->session()->get('email'))->update(['access_token' => $accessToken]);

// Set our new access token on the API wrapper and continue to use the API as usual
            $api->setAccessToken($accessToken);

        } elseif (http_response_code(400)) {

            return redirect($this->spotifyLogin());
        }


        $api->setAccessToken($accessToken);

        $accessToken = \App\User::where('email', $request->session()->get('email'))->pluck('access_token')->first();

        return view('mystats', ['api' => $api, 'access_token' => $accessToken]);


    }

}
