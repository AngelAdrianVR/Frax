<?php

use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FavoriteGuestController;
use App\Http\Controllers\CommonAreaController;
use App\Http\Controllers\CommonAreaUserController;
use App\Http\Controllers\CommunityEventController;
use App\Http\Controllers\EmergencyContactController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\GuestHistoryController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\NormController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentFeedbackController;
use App\Http\Controllers\PaymentHistoryController;
use App\Http\Controllers\PaymentTicketController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
Route::get('payments-admin-index', [PaymentController::class, 'adminIndex'])->name('payments.admin-index')->middleware('auth');


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
//--------------------------------------------------------------------------------------------------
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
Route::post('maintenances/{maintenance}/update-with-media', [MaintenanceController::class, 'updateWithMedia'])->name('maintenances.update-with-media')->middleware('auth');
Route::post('maintenances/{maintenance}/store-comment', [MaintenanceController::class, 'storeComment'])->name('maintenances.store-comment')->middleware('auth');


//community routes---------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------
Route::resource('posts', PostController::class)->middleware('auth');
Route::post('/posts/increment-views/{postId}', [PostController::class, 'incrementViews'])->name('posts.view')->middleware('auth');
Route::post('/posts/increment-likes/{postId}', [PostController::class, 'incrementLikes'])->name('posts.like')->middleware('auth');
Route::post('posts/update-with-media/{postId}', [PostController::class, 'updateWithMedia'])->name('posts.update-with-media')->middleware('auth');
Route::post('posts/{postId}/store-comment', [PostController::class, 'storeComment'])->name('posts.store-comment')->middleware('auth');
Route::get('posts/{offset}{limit}/load-more-posts', [PostController::class, 'loadMorePosts'])->name('posts.load-more-posts')->middleware('auth'); //carga mas posts con scroll


//reports routes-----------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------
Route::resource('reports', ReportController::class)->middleware('auth');


//community-events routes--------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------
Route::resource('community-events', CommunityEventController::class)->middleware('auth');
Route::post('community-events/{community_event}/update-with-media', [CommunityEventController::class, 'updateWithMedia'])->name('community-events.update-with-media')->middleware('auth');


//neighbors routes---------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------
Route::resource('neighbors', UserController::class)->middleware('auth');


//norms routes-------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------
Route::resource('norms', NormController::class)->middleware('auth');


//supports routes-------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------
Route::resource('supports', SupportController::class)->middleware('auth');


//comments routes-------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------
Route::resource('comments', CommentController::class)->middleware('auth');


//services routes-------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------
Route::resource('services', ServiceController::class)->middleware('auth');
Route::get('services-get-external-services', [ServiceController::class, 'getExternalServices'])->name('services.get-external-services')->middleware('auth');
Route::get('services-get-services-history', [ServiceController::class, 'getServicesHistory'])->name('services.get-services-history')->middleware('auth');
Route::post('services/{service}/update-with-media', [ServiceController::class, 'updateWithMedia'])->name('services.update-with-media')->middleware('auth');


//contacts routes-------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------
Route::resource('emergency-contacts', EmergencyContactController::class)->middleware('auth');
Route::post('emergency-contacts/{emergencyContact}/update-with-media', [EmergencyContactController::class, 'updateWithMedia'])->middleware('auth')->name('emergency-contacts.update-with-media');


//vehicles routes-------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------
Route::resource('vehicles', VehicleController::class)->middleware('auth');
Route::post('vehicles/{vehicle}/update-with-media', [VehicleController::class, 'updateWithMedia'])->middleware('auth')->name('vehicles.update-with-media');


//pets routes-------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------
Route::resource('pets', PetController::class)->middleware('auth');
Route::post('pets/{pet}/update-with-media', [PetController::class, 'updateWithMedia'])->middleware('auth')->name('pets.update-with-media');


//profile routes-------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------
Route::post('users/{user}/update-personal', [UserController::class, 'updatePersonal'])->middleware('auth')->name('users.profile.update-personal');
Route::get('users-get-notifications', [UserController::class, 'getNotifications'])->name('users.get-notifications')->middleware('auth');
Route::delete('users-delete-notifications', [UserController::class, 'deleteNotifications'])->name('users.delete-user-notifications')->middleware('auth');
Route::post('users-read-notifications', [UserController::class, 'readNotifications'])->name('users.read-user-notifications')->middleware('auth');


// --------------- Calendar routes -----------------
Route::resource('calendars', CalendarController::class)->middleware('auth');
Route::put('calendars-{calendar}-task-done', [CalendarController::class, 'taskDone'])->name('calendars.task-done')->middleware('auth');
Route::put('calendars/set-attendance-confirmation/{calendar}', [CalendarController::class, 'SetAttendanceConfirmation'])->name('calendars.set-attendance-confirmation');
