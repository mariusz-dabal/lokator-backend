<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Avatar extends Model
{
    protected $fillable = ['path'];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::deleting(function ($avatar) {
            Storage::disk('avatars')->delete(trim($avatar->path, 'avatars/'));

            foreach ($avatar->users()->get() as $user) {
               $user->avatar_id = null;
               $user->save();
            }
        });
    }

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function url()
    {
        return env('APP_URL') . '/' . $this->path;
    }
}
