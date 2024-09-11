<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Bonus",
 *     type="object",
 *     title="Bonus",
 *     description="Bonus model",
 *     @OA\Property(property="id", type="integer", description="ID of the bonus"),
 *     @OA\Property(property="promo", type="string", description="Promo code of the bonus"),
 *     @OA\Property(property="count_to_use", type="integer", description="Count to use of the bonus"),
 *     @OA\Property(property="amount", type="number", description="Amount of the bonus"),
 * )
 */
class Bonus extends Model
{
    use HasFactory;

    protected $fillable = [
        'promo',
        'count_to_use',
        'amount',
    ];
}
