<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::apiResource("/burger",\App\Http\Controllers\BurgerController::class);
Route::apiResource("/client",\App\Http\Controllers\ClientController::class);
Route::apiResource("/commande",\App\Http\Controllers\CommandeController::class);
Route::get('/valideCom/{id}', [\App\Http\Controllers\CommandeController::class, 'valideCom']);
Route::get('/validePay/{id}', [\App\Http\Controllers\CommandeController::class, 'validePay']);
Route::get('/commandeTerminer', [\App\Http\Controllers\CommandeController::class, 'commandeTerminer']);
Route::apiResource('payement',\App\Http\Controllers\PayementController::class);
Route::get('commandeAnnuler',[\App\Http\Controllers\CommandeController::class, 'commandeAnnuler']);
Route::get('recette',[\App\Http\Controllers\CommandeController::class, 'getRecette']);

Route::get('listcommandeValide',[\App\Http\Controllers\CommandeController::class, 'getCommandeValide']);
Route::get('listcommandeAnnuler',[\App\Http\Controllers\CommandeController::class, 'getCommandeAnnuler']);
Route::get('listcommandeEnCour',[\App\Http\Controllers\CommandeController::class, 'getCommandeEnCour']);

Route::get('ventesMensuelles',[\App\Http\Controllers\PayementController::class, 'ventesMensuelles']);
