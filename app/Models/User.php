<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    public function assignRole($role)
    {
        if(is_string($role))
        {
            $role = Role::whereName($role)->firstOrFail();
        }
        $this->roles()->sync($role, false);
    }
    public function abilities()
    {
       return $this->roles->map->abilities->flatten()->pluck('name');
    }


   // public function getRouteKeyName()
   // {
   //     return 'name';
   // }

    public function threads()
    {
        return $this->HasMany(Thread::class)
            ->orderBy('updated_at','desc');
    }

    public function reply()
    {
        return $this->hasMany(Reply::class);
    }

    public function isOnline()
    {
       return Cache::has('user-is-online-' . $this->id);
    }

    public function forum()
    {
        return $this->HasMany(Forum::class);
    }

    public function category()
    {
        return $this->HasMany(Category::class);
    }
}
