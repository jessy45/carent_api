<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\FavoriController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\SpecificationVehiculeController;
use App\Http\Controllers\VehiculeController;
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
// Routes pour les véhicules
Route::apiResource('vehicules', VehiculeController::class);

// Routes pour les catégories
Route::apiResource('categories', CategorieController::class);

// Routes pour les clients
Route::apiResource('clients', ClientController::class);

// Routes pour les locations
Route::apiResource('locations', LocationController::class);

// Routes pour les paiements
Route::apiResource('paiements', PaiementController::class);

// Routes pour les favoris
Route::apiResource('favoris', FavoriController::class);

// Routes pour les spécifications des véhicules
Route::apiResource('specifications-vehicules', SpecificationVehiculeController::class);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->put('/user/update', [AuthController::class, 'update']);
