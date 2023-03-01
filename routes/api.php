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

    // Filtro appartamenti con i servizi
    Route::get('apartments/{services}', [ApartmentController::class, 'apartments_w_services']);

    // Ottenre i dati per la single page
    Route::get('apartment/show/{slug}', [ApartmentController::class, 'show']);

    // Filtro appartamenti per indirizzo
    // Route::get('search/apartment/{query}', [ApartmentController::class, 'search_by_address']);

    // Filtro appartamenti per indirizzo con servizi
    // Route::get('search/apartment/{query}/{services}', [ApartmentController::class, 'search_by_address_with_filter']);

    // Ottenere tutti gli appartamenti attualmente sponsorizzati
    Route::get('sponsored-apartments', [ApartmentController::class, 'get_sponsored_apartments']);

    Route::get('near-apartments-to/address={address}&radius={radius}&rooms={rooms}&beds={beds}&services={services}', [ApartmentController::class, 'get_near_apartments']);

/*----------------------
    SERVICES API 
----------------------*/
    Route::get('services', [ServiceController::class, 'index']);

/*----------------------
    MESSAGE API
----------------------*/
    Route::post('message/create/email={email}&content={content}&apartmentId={apartment_id}', [MessageController::class, 'create']);
