<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OwnerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});




// Auth Route
Route::post('/auth', [AuthController::class, "login"]);
// Route::post('/auth/register', [AuthController::class, "register"]);

// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// @@@@@@@@@@@@@@@@@@@@  Protected Routes      @@@@@@@@@@@@@@@@@
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
Route::middleware(['auth:api'])->group(function () {

// #################
// Auth Routes
// #################
    Route::post('/auth/checkpin/{id}', [AuthController::class, "checkPin"]);
    Route::get('/auth', [AuthController::class, "getUserWithRestaurent"]);
// #################
// Owner Routes
// Authorization must be hide for some routes
// #################
Route::post('/owner', [OwnerController::class, "createUser"]);
Route::post('/owner/user/registration', [OwnerController::class, "createUser2"]);
// guest user
Route::post('/owner/guestuserregister', [OwnerController::class, "createGuestUser"]);
Route::post('/owner/staffregister/{restaurantId}', [OwnerController::class, "createStaffUser"]);

});
