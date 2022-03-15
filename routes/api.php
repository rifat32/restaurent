<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\VariationController;
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




// Auth Route login user
Route::post('/auth', [AuthController::class, "login"]);
 Route::post('/auth/register', [AuthController::class, "register"]);

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
// Authorization may be hide for some routes I do not know
// #################
Route::post('/owner', [OwnerController::class, "createUser"]);
Route::post('/owner/user/registration', [OwnerController::class, "createUser2"]);
// guest user
Route::post('/owner/guestuserregister', [OwnerController::class, "createGuestUser"]);
// end of guest user
Route::post('/owner/staffregister/{restaurantId}', [OwnerController::class, "createStaffUser"]);

Route::post('/owner/pin/{ownerId}', [OwnerController::class, "updatePin"]);

Route::get('/owner/{ownerId}', [OwnerController::class, "getOwnerById"]);
Route::get('/owner/getAllowner/withourrestaurant', [OwnerController::class, "getOwnerNotHaveRestaurent"]);
Route::get('/owner/loaduser/bynumber/{phoneNumber}', [OwnerController::class, "getOwnerByPhoneNumber"]);

Route::patch('/owner/updateuser/{userId}', [OwnerController::class, "updateUser"]);
Route::patch('/owner/profileimage/{userId}', [OwnerController::class, "updateImage"]);

// #################
// Restaurent Routes

// #################
Route::post('/restaurant/{ownerId}', [RestaurantController::class, "storeRestaurent"]);
Route::patch('/restaurant/uploadimage/{restaurentId}', [RestaurantController::class, "uploadRestaurentImage"]);
Route::patch('/restaurant/UpdateResturantDetails/{restaurentId}', [RestaurantController::class, "UpdateResturantDetails"]);

Route::patch('/restaurant/UpdateResturantDetails/byadmin/{restaurentId}', [RestaurantController::class, "UpdateResturantDetailsByAdmin"]);
Route::get('/restaurant/{restaurantId}', [RestaurantController::class, "getrestaurantById"]);
Route::get('/restaurant', [RestaurantController::class, "getAllRestaurants"]);
Route::get('/restaurant/RestuarantbyID/{restaurantId}', [RestaurantController::class, "getrestaurantById"]);
Route::get('/restaurant/Restuarant/tables/{restaurantId}', [RestaurantController::class, "getrestaurantTableByRestaurantId"]);

// #################
// variation Routes

// #################
Route::post('/variation/variation_type', [VariationController::class, "storeVariationType"]);
Route::post('/variation/variation_type/multiple/{restaurantId}', [VariationController::class, "storeMultipleVariationType"]);
Route::patch('/variation/variation_type/multiple', [VariationController::class, "updateMultipleVariationType"]);
Route::patch('/variation/variationtype', [VariationController::class, "updateVariationType"]);

Route::post('/variation/variationtype', [VariationController::class, "updateVariationType"]);
Route::post('/variation', [VariationController::class, "storeVariation"]);

Route::post('/variation/multiple/varations', [VariationController::class, "storeMultipleVariation"]);

Route::patch('/variation', [VariationController::class, "updateVariation"]);

Route::post('/variation/dish_variation', [VariationController::class, "storeDishVariation"]);

Route::post('/variation/multiple/dish_variation/{dishId}', [VariationController::class, "storeMultipleDishVariation"]);

Route::get('/variation/dish_variation/{dishId}', [VariationController::class, "getAllDishVariation"]);

Route::patch('/variation/dish_variation', [VariationController::class, "updateDishVariation"]);
Route::get('/variation/{restaurantId}/{dishId}', [VariationController::class, "getAllVariationWithDish"]);

Route::get('/variation/type/count/{typeId}', [VariationController::class, "getAllVariationByType_Id"]);
Route::delete('/variation/unlink/{typeId}/{dishId}', [VariationController::class, "deleteDishVariation"]);






});
