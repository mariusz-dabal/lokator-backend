<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{
    protected $fillable = ['path'];

    public function url()
    {
        return env('APP_URL') . '/' . $this->path;
    }
}
