<?php

use App\Http\Controllers\AirportController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FlightController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/airport', [AirportController::class,'search']);
Route::get('/flight', [FlightController::class, 'search']);

Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);

Route::post('/booking', [BookingController::class,'booking']);