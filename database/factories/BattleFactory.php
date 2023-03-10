<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Battle>
 */
class BattleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // da bi generisao razlicite
        $max_user_id = DB::table('users')->max('id');
        $ids = array();
        while (count($ids) < 2) {
            $random = mt_rand(1, $max_user_id);
            if (!in_array($random, $ids)) {
                $ids[] = $random;
            }
        }

        // armije
        $army1 = mt_rand(1,20000);
        $army2 = mt_rand(1,20000);

        $winner = 0;
        if($army1>$army2){
            $winner_id = $ids[0];
        }
        if($army1<$army2){
            $winner_id = $ids[1];
        }

        // mapa
        $max_map_id = DB::table('maps')->max('id');
        $map = mt_rand(1,$max_map_id);

        return [
            'player1_id' => $ids[0],
            'player2_id' => $ids[1],
            'army1' => $army1,
            'army2' => $army2,
            'map_id' => $map,
            'winner_id' => $winner_id,
            'date' => now()
        ];
    }

}
