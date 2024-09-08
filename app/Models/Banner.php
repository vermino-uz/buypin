<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @OA\Schema(
 *     schema="Banner",
 *     type="object",
 *     title="Banner",
 *     description="Banner model",
 *     @OA\Property(property="id", type="integer", description="ID of the banner"),
 *     @OA\Property(property="image", type="string", description="Image of the banner"),
 *     @OA\Property(property="text", type="string", description="Text of the banner"),
 *     @OA\Property(property="url", type="string", description="URL of the banner"),
 * )
 */
class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'text',
        'url',
    ];
}
