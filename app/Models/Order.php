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
        'batata',
        'take_away',
        'sauces',
        'amount',
        'money_collected',
        'to_collect',
        'mp',
        'last_edition',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function year()
    {
        return $this->belongsTo(Year::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
