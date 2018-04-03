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

    protected $client_id;
    protected $client_secret;
    protected $redirect_uri;
    protected $options;
    protected $session;
    protected $api;



    public function __construct()
    {

        $this->client_id = env('SPOTIFY_KEY');
        $this->client_secret = env('SPOTIFY_SECRET');
        $this->redirect_uri = env('SPOTIFY_REDIRECT_URI');
        $this->options = [

            'scope' => ['user-top-read',
                'playlist-read-private',
                'user-read-private',
                'user-follow-read',
                'playlist-modify-public',
                'playlist-modify-private',]
        ];

        $this->session = new SpotifyWebAPI\Session($this->client_id, $this->client_secret, $this->redirect_uri);

        $this->api = new SpotifyWebAPI\SpotifyWebAPI();

    }

    public function spotifyLogin()
    {
        //Redirect to authorisation page.

        return redirect($this->session->getAuthorizeUrl($this->options));
    }


    protected function retrieveTokens(Request $request)
    {

        $refreshToken = \App\User::where('email', $request->session()->get('email'))->pluck('refresh_token')->first();


        if (empty($refreshToken)) {

            // Request an access token using the code from Spotify
            $this->session->requestAccessToken($_GET['code']);

            $accessToken = $this->session->getAccessToken();
            $refreshToken = $this->session->getRefreshToken();

            //Store access and refresh tokens in DB

            \App\User::where('email', $request->session()->get('email'))->update(['access_token' => $accessToken, 'refresh_token' => $refreshToken]);
        }


        //Check for access token expiry via try-catch

        try{

            $this->api->setAccessToken($accessToken);

            $artists = $this->api->getUserFollowedArtists()->artists->items;


        } catch (\Exception $e){

            $this->session->refreshAccessToken($refreshToken);

            $accessToken = $this->session->getAccessToken();

            $this->api->setAccessToken($accessToken);

            \App\User::where('email', $request->session()->get('email'))->update(['access_token' => $accessToken]);


            $artists = $this->api->getUserFollowedArtists()->artists->items;

        }


        // Fetch the saved access token from DB.

        $accessToken = \App\User::where('email', $request->session()->get('email'))->pluck('access_token')->first();

        if (empty($accessToken)) {

            $refreshToken = \App\User::where('email', $request->session()->get('email'))->pluck('refresh_token')->first();

            $this->session->refreshAccessToken($refreshToken);

            $accessToken = $this->session->getAccessToken();

            \App\User::where('email', $request->session()->get('email'))->update(['access_token' => $accessToken]);

        }


        //Check for access token expiry and error server-side.

        /* if (http_response_code(401)) {

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
         }*/


        $api = $this->api;
        $api->setAccessToken($accessToken);


        $accessToken = \App\User::where('email', $request->session()->get('email'))->pluck('access_token')->first();

        return view('mystats', ['api' => $api, 'access_token' => $accessToken]);


    }


}
