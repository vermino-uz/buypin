<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @OA\Schema(
 *     schema="BotUser",
 *     type="object",
 *     title="BotUser",
 *     description="BotUser model",
 *     @OA\Property(property="id", type="integer", description="ID of the user"),
 *     @OA\Property(property="name", type="string", description="Name of the user"),
 *     @OA\Property(property="email", type="string", description="Email of the user"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Creation timestamp"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Update timestamp")
 * )
 */
class BotUser extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $fillable=[
        'user_id',
        'full_name',
        'balance',
        'coin',
        'langauge',
        'phone_number',
        'pfp',
    ];
}
