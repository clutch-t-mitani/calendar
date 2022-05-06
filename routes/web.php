<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LivewireTestController;
use App\Http\Controllers\ReservationController;


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

Route::group(['middleware' => 'auth'], function() {
    Route::controller(HomeController::class)->group (function () {
        //一覧画面表示
        Route::get('/home', 'index')->name('index');
    });
    Route::controller(ReservationController::class)->group (function () {
        Route::get('/reserve/{id}', 'show')->name('show');
        Route::post('/reserve/store', 'store')->name('store');
    });
});

Route::controller(LivewireTestController::class)->prefix('livewire-test')->group(function(){
    Route::get('/index', 'index');
});




Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';