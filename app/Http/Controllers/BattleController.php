<?php

namespace App\Http\Controllers;

use App\Http\Resources\BattleCollection;
use App\Http\Resources\BattleResource;
use App\Models\Battle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BattleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $battles = Battle::all();
        return new BattleCollection($battles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'army1' => 'required|integer',
            'map_id' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        //trazim id od ulogovanog korisnika - on je player1
        $player1_id = auth()->id();

        // ostale podatke treba automatksi generisati, kao simulira se neka borba sa drugim korisnikom
        // fora je da ne sme da dobije samog sebe, pa cu prvo izvuci maksimalan broj korisnika
        $max_user_id = DB::table('users')->max('id');
        $player2_id = mt_rand(1,$max_user_id);
        // proveravam da nije slucajno isti id kao korisnik, ako jeste opet generisi
        while($player2_id == auth()->id()){
            $player2_id = mt_rand(1,$max_user_id);
        }
        
        //generisem randomnu armiju za drugog korisnika i odlucujemo pobednika
        $army1 = $request->army1;
        $army2 = mt_rand(1,20000);
        $winner_id = 0;
        if($army1 > $army2){
            $winner_id = $player1_id;
        }else{
            $winner_id = $player2_id;
        }

        //vezivanje tih generisanih na request
        $request->merge(['player1_id' => $player1_id]);
        $request->merge(['player2_id'=> $player2_id]);
        $request->merge(['army2' => $army2]);
        $request->merge(['winner_id'=> $winner_id]);


        $battle = Battle::create($request->all());
    
        return response()->json(['Battle joined successfully.', new BattleResource($battle)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Battle  $battle
     * @return \Illuminate\Http\Response
     */
    public function show(Battle $battle)
    {
        return new BattleResource($battle);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Battle  $battle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Battle $battle)
    {
        $validator = Validator::make($request->all(),[
            'army1' => 'required|integer',
            'map_id' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        //ovde vec ima player2_id i army2, koristim njih
        $player1_id = auth()->id();

        if($player1_id != $battle->player1_id){
            return response()->json("Unable to edit other people's battles. Only your own battles as player1");
        }

        $player2_id = $battle->player2_id;
        
        $map_id = $request->map_id;
        $army1 = $request->army1;
        $army2 = $battle->army2;
        $winner_id = 0;
        if($army1 > $army2){
            $winner_id = $player1_id;
        }else{
            $winner_id = $player2_id;
        }

        $battle->army1 = $army1;
        $battle->map_id = $map_id;
        $battle->winner_id = $winner_id;
        $battle->save();
    
        return response()->json(['Battle updated.', new BattleResource($battle)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Battle  $battle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Battle $battle)
    {
        $battle->delete();
        return response()->json("Battle deleted successfully.");
    }
}
