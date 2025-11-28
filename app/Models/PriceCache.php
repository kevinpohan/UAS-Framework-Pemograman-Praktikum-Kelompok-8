<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceCache extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_id',
        'price',
        'fetched_at',
        'raw_response',
    ];

    protected $casts = [
        'fetched_at' => 'datetime',
        'raw_response' => 'array',
    ];

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}
