<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;

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

//Start Frontend Routes

Route::get('/', [HomeController::class, 'showHomePage'])->name('index');
Route::get('/about-us', [HomeController::class, 'showAboutUsPage'])->name('about.us');
Route::get('/our-vision', [HomeController::class, 'showOurVisionPage'])->name('our.vision');
Route::get('/how-it-works', [HomeController::class, 'showHowItWorkPage'])->name('how.it.works');
Route::get('/contact-us', [HomeController::class, 'showContactUsPage'])->name('contact.us');
Route::post('/contact-us/store', [HomeController::class, 'storeContactUs'])->name('contact.us.store');
Route::get('/menu', [HomeController::class, 'showMenuPage'])->name('show.menu');

//End Frontend Routes

//Start User Routes

Auth::routes();

Route::prefix('user')->middleware(['auth'])->group(function () {
   
    Route::get('profile', [UserController::class, 'showProfile'])->name('user.show.profile');
    
});

//End User Routes

// Route::get('/menu', [FoodController::class, 'showMenu'])->name('show-menu');
Route::get('/menu-details/{menu_id}', [FoodController::class, 'showMenuDetails'])->name('show-menu-details');

Route::group(['middleware' => ['auth-customer']], function(){
    Route::get('/order/payment', [PaymentController::class, 'orderPayment'])->name('order.payment');
    Route::get('/order/payment/success', [PaymentController::class, 'orderSuccess'])->name('order.payment.success');
    Route::get('/order/cancel', [PaymentController::class, 'orderCancel'])->name('order.payment.cancel');
});

Route::group(['middleware' => ['auth-cook-or-admin']], function(){
    Route::get('/home', [DashboardController::class, 'showDashboard'])->name('show-dashboard');

});

// Cook Routes
Route::group(['middleware' => ['auth-cook']], function() {
    Route::get('/food-selection', [FoodController::class, 'viewFoodSelection'])->name('view-food-selection');
    Route::get('/food-selection/change/{meal_id?}', [FoodController::class, 'viewFoodSelectionForm'])->name('view-food-selection-form');
    Route::post('/food-selection/change/{meal_id?}', [FoodController::class, 'addFoodSelection'])->name('add-food-selection');
    Route::post('/food-selection/{meal_id}/media/upload', [MediaController::class, 'addFoodMedia'])->name('add-food-media');
    Route::post('/food-selection/{meal_id}/media/remove', [MediaController::class, 'removeFoodMedia'])->name('remove-food-media');

    Route::get('/billing', [BillingController::class, 'viewBillingInfo'])->name('view-billing');
    Route::post('/billing', [BillingController::class, 'updateBillingInfo'])->name('update-billing');

    Route::get('/withdraw', [BillingController::class, 'viewBalance'])->name('view-balance');
    Route::post('/withdraw', [BillingController::class, 'checkout'])->name('withdraw');
});


