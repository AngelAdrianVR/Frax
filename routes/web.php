<?php


use App\Http\Controllers\EventController;
use App\Http\Controllers\FavoriteGuestController;
use App\Http\Controllers\CommonAreaController;
use App\Http\Controllers\CommonAreaUserController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentTicketController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

//Payments routes---------------------------------------------------------------------------
//------------------------------------------------------------------------------------------
Route::resource('payments', PaymentController::class)->middleware('auth');
Route::get('payments/{payment_id}/pay', [PaymentController::class, 'pay'])->name('payments.pay')->middleware('auth');

//Common areas routes---------------------------------------------------------------------------
//------------------------------------------------------------------------------------------
Route::resource('common-areas', CommonAreaController::class)->middleware('auth');

//Common areas user (bookings) routes---------------------------------------------------------------------------
//------------------------------------------------------------------------------------------
Route::resource('common-areas-users', CommonAreaUserController::class)->middleware('auth');

//Payment-tickets routes---------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------
Route::resource('payment-tickets', PaymentTicketController::class)->middleware('auth');


//Guests routes-----------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------
Route::resource('guests', GuestController::class)->middleware('auth');
Route::post('guests/update-with-media/{guest}', [GuestController::class, 'updateWithMedia'])->name('guests.update-with-media')->middleware('auth');



//Favorite guests routes-----------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------
Route::resource('favorite-guests', FavoriteGuestController::class)->middleware('auth');
Route::get('favorite-guest-get-all', [FavoriteGuestController::class, 'getAll'])->name('favorite-guests.get-all')->middleware('auth');
Route::post('favorite-guest/update-with-media/{guest}', [FavoriteGuestController::class, 'updateWithMedia'])->name('favorite-guest.update-with-media')->middleware('auth');


//Events routes-----------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------
Route::resource('events', EventController::class)->middleware('auth');
