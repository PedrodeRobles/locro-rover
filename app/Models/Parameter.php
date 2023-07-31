<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    use HasFactory;

    protected $fillable = [
        'year_id',
        'unit_price',
        'promo_unit_price',
        'amount_for_promo',
    ];
}
