<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController; // Make sure this path is correct for your controller

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

// Default route for authenticated user info (often included by Laravel)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Your resourceful API routes for 'gaming'
Route::apiResource('gaming', GameController::class);

// Optional: A simple test route to ensure API is working
// Route::get('/test-api', function() {
//     return response()->json(['message' => 'API routes are working!']);
// });