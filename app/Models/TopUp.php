<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopUp extends Model
{
    use HasFactory;
    protected $table = 'top_ups';
    protected $fillable = [
        'user_id',
        'amount',
        'status',   
    ];
}
