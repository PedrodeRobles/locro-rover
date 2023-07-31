<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observation extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'year_id',
        'observation',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function year()
    {
        return $this->belongsTo(Year::class);
    }
}
