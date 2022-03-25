<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DailyViewsController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\NotificationController;
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

// #################
// dailyviews Routes

// #################
Route::post('/dailyviews/{restaurantId}', [DailyViewsController::class, "store"]);
Route::patch('/dailyviews/update/{restaurantId}', [DailyViewsController::class, "update"]);

// #################
// forggor password Routes

// #################

Route::patch('/forgetpassword/changepassword', [ForgotPasswordController::class, "changePassword"]);

// #################
// notification  Routes

// #################

Route::post('/notification/{recieverId}/{orderId}', [NotificationController::class, "storeNotification"]);
Route::patch('/notification/{notificationId}', [NotificationController::class, "updateNotification"]);
Route::get('/notification/{recieverId}', [NotificationController::class, "getNotification"]);
Route::delete('/notification/{notificationId}', [NotificationController::class, "deleteNotification"]);

// #################
// menu  Routes

// #################

Route::post('/menu/{restaurantId}', [MenuController::class, "storeMenu"]);
Route::patch('/menu/update/{MenuId}', [MenuController::class, "updateMenu"]);
Route::get('/menu/{menuId}', [MenuController::class, "getMenuById"]);
Route::get('/menu/AllbuId/{restaurantId}', [MenuController::class, "getMenuByRestaurantId"]);
Route::post('/menu/multiple/{restaurantId}', [MenuController::class, "storeMultipleMenu"]);
Route::patch('/menu/Edit/multiple', [MenuController::class, "updateMultipleMenu"]);
Route::patch('/menu/Updatemenu', [MenuController::class, "updateMenu2"]);
Route::delete('/menu/{menuId}', [MenuController::class, "deleteMenu"]);

// #################
// dish  Routes

// #################

Route::post('/dishes/{menuId}', [DishController::class, "storeDish"]);
Route::patch('/dishes/UpdateDishesDetails/{dishId}', [DishController::class, "updateDish"]);
Route::post('/dishes/uploadimage/{dishId}', [DishController::class, "updateDishImage"]);
Route::get('/dishes/All/dishes/{restaurantId}', [DishController::class, "getAllDishes"]);
Route::get('/dishes/{menuId}', [DishController::class, "getDisuBuMenuId"]);
Route::get('/dishes/getdealsdishes/{dealId}', [DishController::class, "getDishByDealId"]);
Route::get('/dishes/getusermenu/dealsdishes', [DishController::class, "getAllDishesWithDeals"]);
Route::post('/dishes/multiple/{restaurantId}', [DishController::class, "storeMultipleDish"]);
Route::post('/dishes/multiple/deal/{menuId}', [DishController::class, "storeMultipleDealDish"]);
Route::patch('/dishes/Edit/multiple', [DishController::class, "updateMultipleDish"]);
Route::patch('/dishes/Updatedish', [DishController::class, "updateDish2"]);
Route::delete('/dishes/{dishId}', [DishController::class, "deleteDish"]);


});
// #################
// forggor password Routes

// #################

Route::post('/forgetpassword', [ForgotPasswordController::class, "store"]);
Route::patch('/forgetpassword/reset/{token}', [ForgotPasswordController::class, "changePasswordByToken"]);
