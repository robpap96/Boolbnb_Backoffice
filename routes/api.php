<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApartmentController;
use App\Http\Controllers\Api\MessageController;
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
    // Get all apartments
    Route::get('apartments', [ApartmentController::class, 'index']);

    Route::get('apartments/{services}', [ApartmentController::class, 'apartments_w_services']);

    Route::get('apartment/show/{slug}', [ApartmentController::class, 'show']);

    Route::get('search/apartment/{query}', [ApartmentController::class, 'search_by_address']);

    Route::get('search/apartment/{query}/{services}', [ApartmentController::class, 'search_by_address_with_filter']);

/*----------------------
    SERVICES API 
----------------------*/
    Route::get('services', [ServiceController::class, 'index']);

/*----------------------
    MESSAGE API
----------------------*/

    Route::get('message/create/email={email}&content={content}', [MessageController::class, 'create']);