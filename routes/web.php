<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\BillingController;

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
    return view('index');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function(){
    Route::get('/home', [HomeController::class, 'showDashboard'])->name('show-dashboard');

        // Cook Routes
    Route::group(['middleware' => ['auth-cook']], function() {
        Route::get('/food-selection', [FoodController::class, 'viewFoodSelection'])->name('view-food-selection');
        Route::post('/food-selection', [FoodController::class, 'addFoodSelection'])->name('add-food-selection');
        Route::post('/food-selection/media/upload', [MediaController::class, 'addFoodMedia'])->name('add-food-media');
        Route::post('/food-selection/media/remove', [MediaController::class, 'removeFoodMedia'])->name('remove-food-media');

        Route::get('/billing', [BillingController::class, 'viewBillingInfo'])->name('view-billing');
        Route::post('/billing', [BillingController::class, 'updateBillingInfo'])->name('update-billing');
    });
});


