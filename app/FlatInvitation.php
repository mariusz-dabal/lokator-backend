<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FlatInvitation extends Model
{
    protected $fillable=[
        'email',
        'token'
    ];
}
