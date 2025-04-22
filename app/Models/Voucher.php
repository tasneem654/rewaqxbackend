<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $primaryKey = 'voucherid';
    public $incrementing = true;

    protected $fillable = [
        'logo',
        'title',
        'voucher_code', // Added voucher_code
        'amount',
        'point_cost',
        'is_available'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'is_available' => 'boolean'
    ];

    /**
     * The attributes that should be unique.
     *
     * @var array
     */
    public function uniqueIds()
    {
        return ['voucher_code'];
    }
}