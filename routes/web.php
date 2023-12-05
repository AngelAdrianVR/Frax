<?php

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
// Route::get('common-areas-users-active-reservations', [CommonAreaUserController::class, 'activeReservations'])->name('common-areas-users.active-reservations')->middleware('auth');

//Payment-tickets routes---------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------
Route::resource('payment-tickets', PaymentTicketController::class)->middleware('auth');


//Payment-tickets routes---------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------
Route::resource('guests', GuestController::class)->middleware('auth');
