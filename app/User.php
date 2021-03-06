<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Http\Resources\Color as ColorResource;
use App\Http\Resources\Avatar as AvatarResource;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar_id', 'color_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::deleting(function ($user) {
            $user->roles()->detach();
            $user->tokens()->delete();
        });
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    public function hasAnyRole($roles)
    {
        if (is_array($roles)) {
            foreach($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
        } else {
            if ($this->hasRole($roles)) {
                return true;
            }
        }
        return false;
    }

    private function hasRole($role)
    {
        if ($this->roles()->where('name', $role)->first()) {
            return true;
        }
        return false;
    }

    public function attachRole($role)
    {
        if ($this->hasRole($role)) {
            return false;
        }
        $this->roles()->attach(Role::where('name', $role)->first()->id);
    }

    public function getRoles()
    {
        $roles = [];
        foreach ($this->roles()->get() as $role) {
            $roles[] = $role->name;
        }
        return $roles;
    }

    public function avatar()
    {
        return $this->belongsTo('App\Avatar');
    }

    public function getAvatarUrl()
    {
        return $this->avatar()->get()->first()->url();
    }

    public function color()
    {
        return $this->belongsTo('App\Color');
    }

    public function getColor()
    {
        return new ColorResource($this->color()->get()->first());
    }

    public function flat()
    {
        return $this->belongsTo('App\Flat');
    }
}
