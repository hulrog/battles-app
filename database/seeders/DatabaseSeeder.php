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
            ['place'=>'The Trident','description'=>'The mightiest river in the Seven Kingdoms.'],
            ['place'=>"King's Landing",'description'=>'The capital of the realm and location of the Iron Throne.'],
            ['place'=>'Redgrass Field','description'=>'Scene of the decisive battle of the First Blackfyre Rebellion.'],
            ['place'=>'The Gullet','description'=>'A bay that connects the capital to the Narrow Sea.'],
            ['place'=>'The Stepstones','description'=>'An archipelago of islands between Dorne nad Essos.'],
            ['place'=>'The Boneway','description'=>'A treacherous pass through the Red Mountains.'],
            ['place'=>'Riverrun','description'=>'A castle situated on three rivers from which the Tullies rule the Riverlands.'],
            ['place'=>'Coldmoat','description'=>'Ancient seat of the Marshals of the Northmarch tha held off many Westermen invasions.']
        ]);

        $user = new User;
        $user->name = "admin";
        $user->email = "admin@gmail.com";
        $user->password = bcrypt("admin");
        $user->save();

        User::factory(5)->create();

        Battle::factory(10)->create();
    }
}
