<?php

namespace App\Http\Controllers;

use App\Http\Resources\MapCollection;
use App\Http\Resources\MapResource;
use App\Models\Map;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MapController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $maps = Map::all();
        return new MapCollection($maps);
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
            'place' => 'required|string|max:20|regex:/^[A-Z].*/',
            'description' => 'required|string|max:100'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $map = Map::create($request->all());
    
        return response()->json(['Map craeted!', new MapResource($map)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Map  $map
     * @return \Illuminate\Http\Response
     */
    public function show(Map $map)
    {
        return new MapResource($map);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Map  $map
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Map $map)
    {
        $validator = Validator::make($request->all(),[
            'place' => 'required|string|max:20|regex:/^[A-Z].*/',
            'description' => 'required|string|max:100'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $map->place = $request->place;
        $map->description = $request->description;
        $map->save();
    
        return response()->json(['Map updated!', new MapResource($map)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Map  $map
     * @return \Illuminate\Http\Response
     */
    public function destroy(Map $map)
    {
        $map->delete();
        return response()->json("Map deleted!");
    }
}
