<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    use HasFactory;

    protected $fillable = [
        'year_id',
        'goal'
    ];

    public function year()
    {
        return $this->belongsTo(Year::class);
    }
}
