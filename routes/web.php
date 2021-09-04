<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;

//Cron Job Controller
use App\Http\Controllers\CronJobController;

//Auth Controllers
use App\Http\Controllers\Auth\ValidationController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\LoginController;

//Cook Controllers
use App\Http\Controllers\Cook\DashboardController as CookDashboardController;
use App\Http\Controllers\Cook\MealController as CookMealController;
use App\Http\Controllers\Cook\FoodMediaController as CookFoodMediaController;
use App\Http\Controllers\Cook\ProfileController as CookProfileController;
use App\Http\Controllers\Cook\BillingInfoController as CookBillingInfoController;
use App\Http\Controllers\Cook\AccountController as CookAccountController;
use App\Http\Controllers\Cook\OrderController as CookOrderController;

//Customer Controllers
use App\Http\Controllers\Customer\Payment\PayPalController as CustomerPaymentPayPalController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;
use App\Http\Controllers\Customer\ProfileController as CustomerProfileController;
use App\Http\Controllers\Customer\BillingInfoController as CustomerBillingInfoController;


//Ajax Controllers
use App\Http\Controllers\Ajax\CountryStateCityController;

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



//End Frontend Routes

//Start User Routes



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




    Route::get('/food-selection', [FoodController::class, 'viewFoodSelection'])->name('view-food-selection');
    Route::get('/food-selection/change/{meal_id?}', [FoodController::class, 'viewFoodSelectionForm'])->name('view-food-selection-form');
    Route::post('/food-selection/change/{meal_id?}', [FoodController::class, 'addFoodSelection'])->name('add-food-selection');
    Route::post('/food-selection/{meal_id}/media/upload', [MediaController::class, 'addFoodMedia'])->name('add-food-media');
    Route::post('/food-selection/{meal_id}/media/remove', [MediaController::class, 'removeFoodMedia'])->name('remove-food-media');

    Route::get('/billing', [BillingController::class, 'viewBillingInfo'])->name('view-billing');
    Route::post('/billing', [BillingController::class, 'updateBillingInfo'])->name('update-billing');

    Route::get('/withdraw', [BillingController::class, 'viewBalance'])->name('view-balance');
    Route::post('/withdraw', [BillingController::class, 'checkout'])->name('withdraw');





//Admin Approve Account
Route::get('approve/account/{secret}', [VerificationController::class, 'accountApprovedByAdmin'])->name('user.account.approve.admin');

//User Email Verification
Route::get('email/verification/{secret}', [VerificationController::class, 'emailVerificationByUser'])->name('user.email.verification');

//Resend User Email Verification
Route::get('resend/email/verification', [VerificationController::class, 'resendVerificationEmail'])->name('user.email.verification.resend');


/*-------------------------------------------------------------------------------
------------------------------------Auth Routes----------------------------------
-------------------------------------------------------------------------------*/

Auth::routes();

Route::get('login', function() {

    \Session::forget('callBackUrl');
    \Session::put(['callBackUrl' => \URL::previous()]);

    return view('auth.login');
    
})->name('login');

//Auth - Validation
Route::prefix('auth')->group(function () {

    Route::prefix('validation')->group(function () {

        //Email
        Route::post('email', [ValidationController::class, 'email'])->name('auth.validation.email');
        //Phone
        Route::post('phone', [ValidationController::class, 'phone'])->name('auth.validation.phone');
    });

    Route::prefix('password')->group(function () {

        Route::get('email', [PasswordController::class, 'email'])->name('auth.password.email');
        Route::post('send-reset-link', [PasswordController::class, 'sendResetLink'])->name('auth.password.send.reset.link');
        Route::get('reset/{token}', [PasswordController::class, 'reset'])->name('auth.password.reset');
        Route::post('reset', [PasswordController::class, 'resetPassword'])->name('auth.password.reset.password');
    });
});




/*-------------------------------------------------------------------------------
------------------------------------Cook Routes----------------------------------
-------------------------------------------------------------------------------*/

Route::prefix('cook')->middleware(['auth-cook'])->group(function () {

    //Dashboard Routes
    Route::prefix('dashboard')->group(function () {

        Route::get('/', [CookDashboardController::class, 'dashboard'])->name('cook.dashboard');
    });

    //Meal Routes
    Route::prefix('manage-meal')->group(function () {

        Route::get('/', [CookMealController::class, 'index'])->name('cook.meal.index');
        Route::get('/create', [CookMealController::class, 'create'])->name('cook.meal.create');
        Route::post('/store', [CookMealController::class, 'store'])->name('cook.meal.store');
        Route::get('/edit/{id}', [CookMealController::class, 'edit'])->name('cook.meal.edit');
        Route::get('/remove-media/{id}', [CookMealController::class, 'removeMedia'])->name('cook.meal.remove.media');
        Route::post('/update/{id}', [CookMealController::class, 'update'])->name('cook.meal.update');
    });

    //Meal Media Routes
    Route::prefix('meal-media')->group(function () {

        Route::get('/', [CookFoodMediaController::class, 'index'])->name('cook.meal.media.index');
    });

    //Order History Routes
    Route::prefix('order')->group(function () {

        Route::get('/history', [CookOrderController::class, 'orderHistory'])->name('cook.order.history');
        Route::get('/review/{id}', [CookOrderController::class, 'orderReview'])->name('cook.order.review');
        Route::get('/detail/{id}', [CookOrderController::class, 'orderDetail'])->name('cook.order.detail');
        Route::post('/save-review', [CookOrderController::class, 'saveReview'])->name('cook.order.save.review');
    }); 

    //Profile Routes
    Route::prefix('profile')->group(function () {

        Route::get('/', [CookProfileController::class, 'index'])->name('cook.profile.index');
        Route::post('/save', [CookProfileController::class, 'save'])->name('cook.profile.save');
    });

    //Billing Routes
    Route::prefix('billing-info')->group(function () {

        Route::get('/', [CookBillingInfoController::class, 'index'])->name('cook.billing.info.index');
        Route::post('save', [CookBillingInfoController::class, 'saveInfo'])->name('cook.billing.info.save');
    });

    //Account Routes
    Route::prefix('account')->group(function () {

        Route::get('/', [CookAccountController::class, 'index'])->name('cook.account.index');
        Route::get('/withdraw-amount', [CookAccountController::class, 'withdrawAmount'])->name('cook.account.withdraw.amount');
        Route::post('/withdraw', [CookAccountController::class, 'withdraw'])->name('cook.account.withdraw');

    });
    
});


/*-------------------------------------------------------------------------------
------------------------------------Customer Routes------------------------------
-------------------------------------------------------------------------------*/

Route::prefix('customer')->group(function () {

    //Payment Routes
    Route::prefix('payment')->group(function () {

        Route::post('/paypal', [CustomerPaymentPayPalController::class, 'pay'])->name('customer.payment.paypal.pay');
        Route::get('/status', [CustomerPaymentPayPalController::class, 'getPaymentStatus'])->name('customer.payment.paypal.status');
    });
    
});


Route::prefix('customer')->middleware(['auth-customer'])->group(function () {

    //Dashboard Routes
    Route::prefix('dashboard')->group(function () {

        Route::get('/', [CustomerDashboardController::class, 'dashboard'])->name('customer.dashboard');
    });

    //Order History Routes
    Route::prefix('order')->group(function () {

        Route::get('/history', [CustomerOrderController::class, 'orderHistory'])->name('customer.order.history');
        Route::get('/review/{id}', [CustomerOrderController::class, 'orderReview'])->name('customer.order.review');
        Route::get('/detail/{id}', [CustomerOrderController::class, 'orderDetail'])->name('customer.order.detail');
        Route::post('/save-review', [CustomerOrderController::class, 'saveReview'])->name('customer.order.save.review');
    });

    //Profile Routes
    Route::prefix('profile')->group(function () {

        Route::get('/', [CustomerProfileController::class, 'index'])->name('customer.profile.index');
        Route::post('/save', [CustomerProfileController::class, 'save'])->name('customer.profile.save');
    });

    //Billing Routes
    Route::prefix('billing-info')->group(function () {

        Route::get('/', [CustomerBillingInfoController::class, 'index'])->name('customer.billing.info.index');
        Route::post('save', [CustomerBillingInfoController::class, 'saveInfo'])->name('customer.billing.info.save');
    });
    
});


/*-------------------------------------------------------------------------------
---------------------------------Ajax Request Routes-----------------------------
-------------------------------------------------------------------------------*/

Route::prefix('ajax')->group(function () {

    Route::post('get-state', [CountryStateCityController::class, 'getState'])->name('ajax.get.state');
    Route::post('get-city', [CountryStateCityController::class, 'getCity'])->name('ajax.get.city');
});


/*-------------------------------------------------------------------------------
-----------------------------------Frontend Routes-------------------------------
-------------------------------------------------------------------------------*/

Route::get('/', [HomeController::class, 'showHomePage'])->name('index');
Route::get('/about-us', [HomeController::class, 'showAboutUsPage'])->name('about.us');
Route::get('/our-vision', [HomeController::class, 'showOurVisionPage'])->name('our.vision');
Route::get('/how-it-works', [HomeController::class, 'showHowItWorkPage'])->name('how.it.works');
Route::get('/contact-us', [HomeController::class, 'showContactUsPage'])->name('contact.us');
Route::post('/contact-us/store', [HomeController::class, 'storeContactUs'])->name('contact.us.store');
Route::get('/menu', [HomeController::class, 'showMenuPage'])->name('show.menu');
Route::get('/menu/meal-details/{id}', [HomeController::class, 'showMealDetail'])->name('show.meal.detail');


/*-------------------------------------------------------------------------------
---------------------------------Cron Job Routes-----------------------------
-------------------------------------------------------------------------------*/

Route::prefix('cron-job')->group(function () {

    Route::get('meal', [CronJobController::class, 'index'])->name('cron.job.meal.index');
});