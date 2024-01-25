<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\UserController;

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

// Route for user registration
Route::post('/login', [AuthController::class, 'login']); 
Route::post('/createAdmin', [AuthController::class, 'createAdmin']); 


// Route for retrieving user information using token authentication
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/getProfile', [UserController::class, 'getProfile']);
    Route::get('/getUsers', [UserController::class, 'getUsers']);
    Route::get('/getAllObservations', [UserController::class, 'getAllObservations']);
    Route::post('/createObservation', [UserController::class, 'createObservation']);
    Route::get('/getObservationBySala/{sala}', [UserController::class, 'getObservationBySala']);
});
