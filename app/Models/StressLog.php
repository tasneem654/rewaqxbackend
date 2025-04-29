<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StressLog extends Model
{
    protected $fillable = [
        'user_id',
        'heart_rate',     // in bpm
        'hrv',            // SDNN value in milliseconds (nullable)
        'is_exercising',  // boolean
        'is_stressed',    // boolean result
        'stress_score',   // float (0-1 range)
        'hour_of_day',    // integer (0-23)
        'was_correct',    // nullable boolean for user feedback
        'context_data'    // JSON for future expansion
    ];

    protected $casts = [
        'is_exercising' => 'boolean',
        'is_stressed' => 'boolean',
        'was_correct' => 'boolean',
        'context_data' => 'array'
    ];

    // Relationship to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope for recent readings (used in temporal aggregation)
    public function scopeRecent($query, $minutes = 20)
    {
        return $query->where('created_at', '>=', now()->subMinutes($minutes))
                    ->orderBy('created_at', 'desc');
    }

    // Scope for stressed events
    public function scopeStressed($query)
    {
        return $query->where('is_stressed', true);
    }

    // Scope for daytime readings (6am-10pm)
    public function scopeDaytime($query)
    {
        return $query->whereBetween('hour_of_day', [6, 22]);
    }
}
