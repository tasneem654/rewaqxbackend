<?php

// app/Models/User.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // added 
    protected function casts(): array
    {
        return [
           'email_verified_at' => 'datetime',
            'password' => 'hashed',
            
        ];
    }

    // Define the relationship to Profile
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    // Define the relationship to Points
    public function points()
    {
        return $this->hasOne(Points::class);
    }

    // Define the relationship to Posts
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // Define the relationship to Reactions
    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }
    

}