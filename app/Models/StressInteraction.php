<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StressInteraction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'stress_score',
        'is_stressed',
        'message',
        'timestamp',
        'was_helpful',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'stress_score' => 'decimal:3',
        'is_stressed' => 'boolean',
        'timestamp' => 'datetime',
        'was_helpful' => 'boolean',
    ];

    /**
     * Get the user that owns the stress interaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}