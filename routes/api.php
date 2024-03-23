<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Entries;
use App\Http\Controllers\Api\EntryTypes;

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
    Route::get('/entry-types', EntryTypes\ViewEntryTypesController::class);

    Route::get('/entries', Entries\ViewEntriesController::class);
    Route::get('/entries/{entry}', Entries\ViewEntryController::class);
    Route::post('/entries', Entries\CreateEntryController::class);

    Route::get('/entries/{entry}/samples', Entries\ViewSamplesController::class);
});
