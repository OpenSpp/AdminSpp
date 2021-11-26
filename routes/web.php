<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\Jetstream\DashboardController;
use App\Http\Controllers\Jetstream\Department\DepartmentController;
use App\Http\Controllers\Jetstream\User\UserController;
use App\Http\Controllers\Jetstream\User\AdminController;
use App\Http\Controllers\Jetstream\User\UserJsonController;
use App\Http\Controllers\Jetstream\Room\RoomController;
use App\Http\Controllers\Jetstream\Room\RoomJsonController;
use App\Http\Controllers\Jetstream\Payment\PaymentSppController;
use App\Http\Controllers\Jetstream\Payment\PaymentRegistrasionController;

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
    // return Inertia::render('Welcome', [
    //     'canLogin' => Route::has('login'),
    //     'canRegister' => Route::has('register'),
    //     'laravelVersion' => Application::VERSION,
    //     'phpVersion' => PHP_VERSION,
    // ]);

    return redirect()->route('login');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'is-admin', 'verified'])->group(function () {

    //Route::get('/dashboard', function () {
    //    return Inertia::render('Dashboard');
    //})->name('dashboard');

    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::resource('departments', DepartmentController::class);
    Route::resource('users', UserController::class);
    Route::get('json/users/index', UserJsonController::class)->name('json.users.index');

    Route::resource('rooms', RoomController::class);
    Route::get('json/rooms/index', RoomJsonController::class)->name('json.rooms.index');

    Route::prefix('payment')->group(function () {
        Route::resource('spps', PaymentSppController::class);
        Route::resource('registrations', PaymentRegistrasionController::class);
         
    });


});

Route::middleware(['auth:sanctum', 'is-super-admin', 'verified'])->group(function () {
    Route::resource('admins', AdminController::class);
});
