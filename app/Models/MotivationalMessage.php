<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotivationalMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'message',
        'is_for_stress',
        'stress_score',
        'time_of_day',
        'was_helpful',
    ];

    protected $casts = [
        'is_for_stress' => 'boolean',
        'stress_score' => 'float',
        'was_helpful' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}