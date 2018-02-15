<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReturnStatsController extends Controller
{
    public function returnStats()
    {
        return(view('welcome'));

    }
}
