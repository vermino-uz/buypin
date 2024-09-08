<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @OA\Schema(
 *     schema="Game",
 *     type="object",
 *     title="Game",
 *     description="Game model",
 *     @OA\Property(property="id", type="integer", description="ID of the game"),
 *     @OA\Property(property="game_name", type="string", description="Name of the game"),
 *     @OA\Property(property="thumb", type="string", description="Thumbnail of the game"),
 *     @OA\Property(property="currency", type="string", description="Currency of the game"),
 * )
 */
class Game extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $fillable=[
        'game_name',
        'thumb',
        'currency',
    ];
}
