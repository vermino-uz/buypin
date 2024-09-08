<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    use HasFactory;
    protected $fillable = [
        'game_id', 
        'promo',
        'price',
        'amount', 
        'is_sold'
    ];

    /**
     * Get the game that owns the promo code.
     */
    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
