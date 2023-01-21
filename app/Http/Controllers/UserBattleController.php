<?php

namespace App\Http\Controllers;

use App\Http\Resources\BattleCollection;
use App\Models\Battle;

class UserBattleController extends Controller
{
    public function index($user_id)
    {
        $battles = Battle::where('player1_id', $user_id)->orWhere('player2_id',$user_id)->get();

        if(is_null($battles)){
            return response()->json('Error 404 - Not found.', 404);
        }       
        return new BattleCollection($battles);
    }

    public function wins($user_id)
    {
        $battles = Battle::where('winner_id', $user_id)->get();

        if(is_null($battles)){
            return response()->json('Error 404 - Not found.', 404);
        }
        return new BattleCollection($battles);
    }
}
