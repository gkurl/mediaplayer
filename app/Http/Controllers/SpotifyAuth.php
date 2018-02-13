<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Laravel\Socialite\Facades\Socialite;

class SpotifyAuth extends Controller
{
    public function spotifyLogin(){

        return Socialite::with('spotify')->scopes['user-top-read']->redirect();

    }
}
