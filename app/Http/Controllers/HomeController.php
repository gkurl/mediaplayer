<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

       $refreshToken = \App\User::pluck('refresh_token')->where('email', $request->post('email'));
        $email = \App\User::pluck('email')->where('email', $request->post('email'));



        if (empty($refreshToken->refresh_token)){
            $request->session()->put('email', $email);
           return redirect('login/spotify');
        } else{
            $request->session()->put('email', $email);
            return redirect('/mystats')->with('email', $email);
        }

        }









}
