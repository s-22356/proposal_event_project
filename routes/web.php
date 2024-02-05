<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController\UserController;
use App\Http\Controllers\PaymentController\PaymentController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [UserController::class, 'showHome']);
Route::get('/contact-us',  [UserController::class, 'contactus']);
Route::get('/about-us',  [UserController::class, 'aboutus']);
Route::get('/events',  [UserController::class, 'ProposalEvents'])->name('eventTab');
Route::post('/book-event',  [UserController::class, 'ProposalBookEvents']);
Route::get('/sign-up',  [UserController::class, 'createId']);
Route::get('/log-in',  [UserController::class, 'logInPage']);
Route::get('/log-out',  [UserController::class, 'logout']);

//Payment Route stripe payment gateway
Route::controller(PaymentController::class)->group(function(){
    // Route::get('stripe','stripe')->name('stripe.index');
    Route::get('stripe/checkout','stripeCheckout')->name('stripe.checkout');
    Route::get('stripe/checkout/success','stripeCheckoutSuccess')->name('stripe.checkout.success');
});


Route::post('/generate-mobile-otp', [UserController::class, 'GenerateOtp']);
Route::post('/generate-mobile-secretcode', [UserController::class, 'Generatesecretcode']);
Route::post('/verify-mobile-secretcode', [UserController::class, 'VerifySecretCode']);




Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

