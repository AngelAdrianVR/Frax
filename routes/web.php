<?php


use App\Http\Controllers\EventController;
use App\Http\Controllers\FavoriteGuestController;
use App\Http\Controllers\CommonAreaController;
use App\Http\Controllers\CommonAreaUserController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\GuestHistoryController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\NormController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentFeedbackController;
use App\Http\Controllers\PaymentHistoryController;
use App\Http\Controllers\PaymentTicketController;
use App\Http\Controllers\SupportController;
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


//Payment-tickets routes---------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------
Route::resource('payment-tickets', PaymentTicketController::class)->middleware('auth');
Route::get('payment-tickets-get-all', [PaymentTicketController::class, 'getAll'])->name('payment-tickets.get-all')->middleware('auth');


//Payment-history routes---------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------
Route::resource('payment-histories', PaymentHistoryController::class)->middleware('auth');
Route::get('payment-histories-get-all', [PaymentHistoryController::class, 'getAll'])->name('payment-histories.get-all')->middleware('auth');
Route::get('payment-feedback', [PaymentController::class, 'feedback'])->name('payments.feedback')->middleware('auth');


//Payment-feedback routes---------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------
Route::resource('payment-feedbacks', PaymentFeedbackController::class)->middleware('auth');


//Guests routes------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------
Route::resource('guests', GuestController::class)->middleware('auth');
Route::post('guests/update-with-media/{guest}', [GuestController::class, 'updateWithMedia'])->name('guests.update-with-media')->middleware('auth');


//Favorite guests routes-----------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------
Route::resource('favorite-guests', FavoriteGuestController::class)->middleware('auth');
Route::get('favorite-guest-get-all', [FavoriteGuestController::class, 'getAll'])->name('favorite-guests.get-all')->middleware('auth');
Route::post('favorite-guest/update-with-media/{favorite_guest}', [FavoriteGuestController::class, 'updateWithMedia'])->name('favorite-guests.update-with-media')->middleware('auth');


//Guest history routes-----------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------------
Route::resource('guest-histories', GuestHistoryController::class)->middleware('auth');
Route::get('guest-histories-get-all', [GuestHistoryController::class, 'getAll'])->name('guest-histories.get-all')->middleware('auth');


//Events routes------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------
Route::resource('events', EventController::class)->middleware('auth');


//Common areas routes---------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------
Route::resource('common-areas', CommonAreaController::class)->middleware('auth');


//Common areas user (bookings) routes---------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------
Route::resource('common-areas-users', CommonAreaUserController::class)->middleware('auth');
// Route::get('common-areas-users-active-reservations', [CommonAreaUserController::class, 'activeReservations'])->name('common-areas-users.active-reservations')->middleware('auth');


//maintenances routes------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------
Route::resource('maintenances', MaintenanceController::class)->middleware('auth');


//norms routes-------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------
Route::resource('norms', NormController::class)->middleware('auth');


//supports routes-------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------
Route::resource('supports', SupportController::class)->middleware('auth');
