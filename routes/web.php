<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
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

//Admin Controllers
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ContactMessageController as AdminContactMessageController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\AccountController as AdminAccountController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\MealTypeController as AdminMealTypeController;
use App\Http\Controllers\Admin\MealController as AdminMealController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;

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

Route::get('/cache-clear', function() {

    \Artisan::call('optimize:clear');
});

Route::get('change-lang', [HomeController::class, 'changeLang'])->name('change.lang');

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
---------------------------------Cron Job Routes-----------------------------
-------------------------------------------------------------------------------*/

Route::prefix('cron-job')->group(function () {

    Route::get('meal', [CronJobController::class, 'index'])->name('cron.job.meal.index');
});


/*-------------------------------------------------------------------------------
------------------------------------Admin Routes----------------------------------
-------------------------------------------------------------------------------*/

//Login Routes
Route::get('admin/login', [AdminAuthController::class, 'loginPage'])->name('admin.auth.login.page');

Route::prefix('admin')->middleware(['auth-admin'])->group(function () {

    //Dashboard Routes
    Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');

    //Profile Routes
    Route::get('/profile', [AdminProfileController::class, 'profile'])->name('admin.profile');
    Route::post('/profile/save', [AdminProfileController::class, 'saveProfile'])->name('admin.profile.save');

    //Contact Message Routes
    Route::prefix('contact-message')->group(function () {

        Route::get('/all', [AdminContactMessageController::class, 'all'])->name('admin.contact.message.all');
        Route::get('/view/{id}', [AdminContactMessageController::class, 'view'])->name('admin.contact.message.view');
    });

    //App Settings Routes
    Route::prefix('setting')->group(function () {

        Route::get('/all', [AdminSettingController::class, 'all'])->name('admin.setting.index');
        Route::post('/save', [AdminSettingController::class, 'save'])->name('admin.setting.save');
    });

    //Order Routes
    Route::prefix('order')->group(function () {

        Route::get('/all', [AdminOrderController::class, 'all'])->name('admin.order.all');
        Route::get('/view-edit/{id}', [AdminOrderController::class, 'viewEdit'])->name('admin.order.view.edit');
        Route::post('/save-view-edit/{id}', [AdminOrderController::class, 'saveViewEdit'])->name('admin.order.save.view.edit');
    });

    //Account Routes
    Route::prefix('account')->group(function () {

        Route::prefix('withdraw-request')->group(function () {

            Route::get('/all', [AdminAccountController::class, 'allWithdrawRequest'])->name('admin.account.withdraw.request.all');
            Route::get('/detail/{id}', [AdminAccountController::class, 'detailWithdrawRequest'])->name('admin.account.withdraw.request.detail');
            Route::post('/detail/update/{id}', [AdminAccountController::class, 'updateDetailWithdrawRequest'])->name('admin.account.withdraw.request.detail.update');
        });
    });

    //Meal Type Routes
    Route::prefix('meal-type')->group(function () {

        Route::get('/all', [AdminMealTypeController::class, 'all'])->name('admin.meal.type.all');
        Route::get('/create', [AdminMealTypeController::class, 'create'])->name('admin.meal.type.create');
        Route::post('/save', [AdminMealTypeController::class, 'save'])->name('admin.meal.type.save');
        Route::get('/edit/{id}', [AdminMealTypeController::class, 'edit'])->name('admin.meal.type.edit');
        Route::post('/update/{id}', [AdminMealTypeController::class, 'update'])->name('admin.meal.type.update');
        Route::get('/status/{id}', [AdminMealTypeController::class, 'status'])->name('admin.meal.type.status');
        Route::post('/name/validation', [AdminMealTypeController::class, 'nameValidation'])->name('admin.meal.type.name.validation');
    });

    //Meal Routes
    Route::prefix('meal')->group(function () {

        Route::get('/all', [AdminMealController::class, 'all'])->name('admin.meal.all');
        Route::get('/create', [AdminMealController::class, 'create'])->name('admin.meal.create');
        Route::post('/save', [AdminMealController::class, 'save'])->name('admin.meal.save');
        Route::get('/edit/{id}', [AdminMealController::class, 'edit'])->name('admin.meal.edit');
        Route::post('/update/{id}', [AdminMealController::class, 'update'])->name('admin.meal.update');
        Route::get('/media-remove/{id}', [AdminMealController::class, 'removeMedia'])->name('admin.meal.remove.media');
    });

    //User Routes
    Route::prefix('user')->group(function () {

        Route::get('all', [AdminUserController::class, 'all'])->name('admin.user.all');
        Route::get('create', [AdminUserController::class, 'create'])->name('admin.user.create');
        Route::post('save', [AdminUserController::class, 'save'])->name('admin.user.save');
        Route::get('edit/{id}', [AdminUserController::class, 'edit'])->name('admin.user.edit');
        Route::post('update/{id}', [AdminUserController::class, 'update'])->name('admin.user.update');
        Route::get('status/{id}', [AdminUserController::class, 'status'])->name('admin.user.status');
    });
});