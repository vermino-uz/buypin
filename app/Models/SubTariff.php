<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubTariff extends Model
{
    use HasFactory;
    protected $table = 'sub_tariffs';
    protected $fillable = [
        'tariff_name',
        'game_id',
        'amount',
        'price',
        'is_active',
    ];
}
