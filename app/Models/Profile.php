<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','name', 'role', 'department', 'dateOfBirth'];

    // Define the relationship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}