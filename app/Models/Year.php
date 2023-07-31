<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'active'
    ];

    public function goals()
    {
        return $this->hasOne(Goal::class);
    }

    public function parameters()
    {
        return $this->hasOne(Parameter::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function observations()
    {
        return $this->hasMany(Observation::class);
    }
}
