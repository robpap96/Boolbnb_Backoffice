<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApartmentController;
use App\Http\Controllers\Api\ServiceController;

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

/*----------------------
    APARTMENTS API 
----------------------*/
Route::get('apartments', [ApartmentController::class, 'index']);

Route::get('apartment/{id}', [ApartmentController::class, 'show']);

Route::get('search/apartment/{query}', [ApartmentController::class, 'search_by_address']);

/*----------------------
    SERVICES API 
----------------------*/
Route::get('services', [ServiceController::class, 'index']);



