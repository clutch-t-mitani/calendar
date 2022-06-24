<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LivewireTestController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReservationManagementController;


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

Route::middleware('can:user-higher')->group( function() {
    Route::controller(ReservationController::class)->group (function () {
        // Route::get('/calendar/{id}', 'show')->name('show');
        Route::post('/calendar/store', 'store')->name('store');
    });
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::controller(HomeController::class)->group (function () {
    //一覧画面表示
    Route::get('/', 'index')->name('index');
});

Route::controller(ReservationController::class)->group (function () {
    Route::middleware('auth')->get('/calendar/{id}', 'show')->name('show');
});


Route::middleware('can:manager-higher')->group(function() {
    Route::controller(ReservationManagementController::class)->group (function () {
        //一覧画面表示
        Route::get('/manager/index', 'index')->name('manager.index');
        Route::get('/manager/past', 'past')->name('manager.past');
        Route::post('/manager/delete', 'delete')->name('manager.delete');
        Route::get('/manager/day_management/', 'day_management')->name('manager.day_management');
        Route::post('/manager/reserve_stop', 'reserve_stop')->name('manager.reserve_stop');
    });
});


Route::controller(LivewireTestController::class)->prefix('livewire-test')->group(function(){
    Route::get('/index', 'index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});


// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
