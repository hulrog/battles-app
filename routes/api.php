<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\BattleController;
use App\Http\Controllers\MapController;
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



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


//ako je korisnik uspesno ulogovan moze da pristupi ovoj grupi ruta
//znaci bitno je kad se testira u postmanu da se unosi u Authorization delu
//token koji vrati login ruta
Route::group(['middleware'=>['auth:sanctum']], function() {

    Route::resource('battles', BattleController::class)->only(['show', 'update', 'store', 'destroy']);
    Route::resource('maps', MapController::class)->only(['show', 'update', 'store', 'destroy']);
    Route::get('users/{id}/battles', [UserBattleController::class, 'index'])->name('users.battle.index');
    Route::get('/users/{id}/wins', [UserBattleController::class, 'wins']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

//ako nije onda moze samo ovim rutama (samo da vidi bitke)
Route::resource('battles', BattleController::class)->only(['index']);
Route::resource('maps', MapController::class)->only(['index']);
Route::resource('users', UserController::class)->only(['show','index']);

