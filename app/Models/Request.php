<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Request",
 *     type="object",
 *     title="Request",
 *     description="Request model",
 *     @OA\Property(property="id", type="integer", description="ID of the request"),
 *     @OA\Property(property="user_id", type="integer", description="ID of the user"),
 *     @OA\Property(property="game", type="string", description="Game name"),
 *     @OA\Property(property="tariff", type="string", description="Tariff name"),
 *     @OA\Property(property="account", type="integer", description="Account of the request"),
 *     @OA\Property(property="is_fulfilled", type="boolean", description="Is the request fulfilled"),
 * )
 */
class Request extends Model
{
    use HasFactory;
    protected $table = 'requests';
    protected $fillable = [
        'user_id',
        'game',
        'tariff',
        'price',
        'account',
        'is_fulfilled',
    ];
}