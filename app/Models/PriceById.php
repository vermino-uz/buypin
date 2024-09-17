<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceById extends Model
{
    use HasFactory;
    protected $table = 'price_by_ids';
    protected $fillable = ['game_id', 'amount', 'price', 'is_active'];
}
