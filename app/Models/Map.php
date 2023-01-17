<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Map extends Model
{
    use HasFactory;

    protected $fillable = [
        'place',
        'description',
    ];

    public function battles(){
        return $this->hasMany(Battle::class);
    }
}
