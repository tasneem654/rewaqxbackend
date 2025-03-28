<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OTP extends Model
{
    use HasFactory;

    // Define the table name if it's different from the default
    protected $table = 'otps';

    // Define fillable fields
    protected $fillable = [
        'email',
        'otp',
        'expires_at',
    ];
}

