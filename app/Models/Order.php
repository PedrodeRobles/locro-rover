<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'year_id',
        'user_id',
        'portions',
        'take_away',
        'sauces',
        'amount',
        'money_collected',
        'to_collect',
        'mp',
        'last_edition',
    ];
}
