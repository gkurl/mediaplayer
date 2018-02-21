<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $userCheck = \App\User::where('email', $request->get('email'));

        if (!Auth::check()) {

            redirect('/register');

        } elseif(Auth::check() && $userCheck)

            redirect('login/spotify');

    }



}
