<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'symbol',
        'name',
        'currency',
        'extra_meta',
        'is_visible',
    ];

    protected $casts = [
        'extra_meta' => 'array',
    ];

    public function portfolios()
    {
        return $this->hasMany(Portfolio::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function priceCache()
    {
        return $this->hasOne(PriceCache::class);
    }
}
