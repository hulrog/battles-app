<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Battle extends Model
{
    use HasFactory;

    protected $fillable = [
        'user1',
        'user2',
        'numbers1',
        'numbers2',
        'result'
    ];

    public function map(){
        return $this->belongsTo(Map::class);
    }

    public function player1() {
        return $this->belongsTo(User::class, 'player1_id');
    }

    public function player2() {
        return $this->belongsTo(User::class, 'player2_id');
    }

    public function winner() {
        return $this->belongsTo(User::class, 'winner_id');
    }
}
