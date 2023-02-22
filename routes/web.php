<?php

use App\Http\Controllers\Admin\ApartmentController;
use App\Http\Controllers\Admin\SponsorshipController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('apartments', ApartmentController::class)->parameters(['apartments' => 'apartment:slug']);
    Route::resource('sponsors', SponsorshipController::class)->parameters(['sponsors' => 'sponsor:slug']);
    Route::resource('messages', MessageController::class);
    Route::get('/sponsors/{name}/buy', [SponsorshipController::class, "buy_sponsor"])->name('sponsors.buy');

    // Route::get('/sponsors', [SponsorshipController::class], "index")->name('sponsors.index');
});

require __DIR__.'/auth.php';
