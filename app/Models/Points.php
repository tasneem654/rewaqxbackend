<?php

// app/Models/Points.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Points extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'totalPoints'];

    // Define the relationship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}