<?php

// app/Models/User.php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['email'];

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