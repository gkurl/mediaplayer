<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tokens extends Model
{
    public $timestamps = false;
    protected $fillable = ['refresh_token'];
}
