<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="PromoCode",
 *     type="object",
 *     title="PromoCode",
 *     description="PromoCode model",
 *     @OA\Property(property="id", type="integer", description="ID of the promo code"),
 *     @OA\Property(property="game_id", type="integer", description="ID of the game"),
 *     @OA\Property(property="promo", type="string", description="Promo code"),
 *     @OA\Property(property="price", type="number", description="Price of the promo code"),
 *     @OA\Property(property="amount", type="number", description="Amount of the promo code"),
 *     @OA\Property(property="is_sold", type="boolean", description="Is the promo code sold"),
 * )
 */
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
