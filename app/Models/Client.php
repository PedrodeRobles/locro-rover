<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'last_name',
        'phone_number',
        'direction',
        'postal_code',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function observations()
    {
        return $this->hasMany(Observation::class);
    }
}
