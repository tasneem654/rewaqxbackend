<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Define fillable fields (if any)
    protected $fillable = [
      'user_id',
      'content',
      'reactions',
      'comments',
      'time',
      'image_path',
        // Add other fields as needed
    ];

    // Define relationships (if any)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
      