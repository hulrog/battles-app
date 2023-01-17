<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Battle;
use App\Models\Map;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Map::truncate();
        User::truncate();
        Battle::truncate();

        Map::insert([
            ['place'=>'Winterfell','description'=>'Seat of the Starks and the largest castle in the North.'],
            ['place'=>'Harrenhal','description'=>'Monstrous castle built by Harren the Black on the shore of Gods Eye.'],
            ['place'=>'The Trident','description'=>'The mightiest river in the Seven Kingdoms.']
        ]);
        $battle = new Battle;
        $battle->army1='100';
        $battle->army2='200';
        $battle->map_id=1;
        $battle->save();

        $battle = new Battle;
        $battle->army1='10000';
        $battle->army2='2000';
        $battle->map_id=2;
        $battle->save();

        $battle = new Battle;
        $battle->army1='23000';
        $battle->army2='25000';
        $battle->map_id=3;
        $battle->save();

        $battle = new Battle;
        $battle->army1='5000';
        $battle->army2='3500';
        $battle->map_id=1;
        $battle->save();

        Map::find(1)->battles;

        $user = new User;
        $user->name = "petar";
        $user->email = "petar99t@gmail.com";
        $user->password = bcrypt("petar123");
        $user->save();

        $user = new User;
        $user->name = "sone";
        $user->email = "soneM@gmail.com";
        $user->password = bcrypt("sone123");
        $user->save();

        User::factory(3)->create();

        $battle = Battle::find(1);
        $battle->player1_id="1";
        $battle->player2_id="2";
        $battle->winner_id="2";
        $battle->save();
    }
}
