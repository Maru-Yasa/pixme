<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
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


    public static function rules ($id=0, $merge=[]) {
        $regex = '/[\'\/~`\!@#\$%\^&\*\(\)-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/';
        return array_merge(
            [
                'username'  => ['required',"not_regex:".$regex,'min:4','max:12','unique:users,username' . ($id ? ",$id" : '')],
                'email'     => 'email|unique:member'. ($id ? ",id,$id" : ''),
                'password'  => 'required|min:6'
            ], 
            $merge);
    }

}
