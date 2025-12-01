<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Earning extends Model
{
    use HasFactory;

    protected $primaryKey = 'earning_id';

    protected $fillable = [
        'amount',
        'state',
        'at'
    ];

    protected $casts = [
        'at' => 'datetime',
        'amount' => 'decimal:2'
    ];
}
