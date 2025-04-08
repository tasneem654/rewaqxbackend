<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OTP extends Model
{
    use HasFactory;

    // Define the table name 
    protected $table = 'otps';

  
    protected $fillable = [
        'email',
        'otp',
        'expires_at',
    ];
}

