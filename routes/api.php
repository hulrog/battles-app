<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\BattleController;
use App\Http\Controllers\UserBattleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);

Route::get('users/{id}/battles', [UserBattleController::class, 'index'])->name('users.battle.index');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


//resource rute na kraju
Route::resource('battles', BattleController::class);

//ako je korisnik uspesno ulogovan moze da pristupi ovoj grupi ruta
//znaci bitno je kad se testira u postmanu da se unosi u Authorization delu
//token koji vrati login ruta
Route::group(['middleware'=>['auth:sanctum']], function() {
    Route::get('/profil', function (Request $request){
        return auth()->user();
    });

    Route::resource('battles', BattleController::class)->only(['update', 'store', 'destroy']);

    Route::post('/logout', [AuthController::class, 'logout']);
});

//ako nije onda moze samo ovoj ruti (samo da vidi bitke)
Route::resource('battles', BattleController::class)->only(['index']);
