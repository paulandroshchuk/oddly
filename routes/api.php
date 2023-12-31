<?php

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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/entries', \App\Http\Controllers\Api\Entries\ViewEntriesController::class);
    Route::post('/entries', \App\Http\Controllers\Api\Entries\CreateEntryController::class);
});
