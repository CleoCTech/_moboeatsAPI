<?php

use App\Http\Controllers\Api\V1\AdminController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CartController;
use App\Http\Controllers\Api\V1\CartItemController;
use App\Http\Controllers\Api\V1\FCategorySubCategoryController;
use App\Http\Controllers\Api\V1\FoodCommonCategoryController;
use App\Http\Controllers\Api\V1\FooSubCategoryController;
use App\Http\Controllers\Api\V1\MenuBookmarkController;
use App\Http\Controllers\Api\V1\MenuController;
use App\Http\Controllers\Api\V1\MenuPriceController;
use App\Http\Controllers\Api\V1\NotificationController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\OrdererController;
use App\Http\Controllers\Api\V1\PaymentController;
use App\Http\Controllers\Api\V1\QuestionnaireController;
use App\Http\Controllers\Api\V1\RestaurantBookmarkController;
use App\Http\Controllers\Api\V1\RestaurantController;
use App\Http\Controllers\Api\V1\RestaurantDocumentsController;
use App\Http\Controllers\Api\V1\RestaurantOperatingHoursController;
use App\Http\Controllers\Api\V1\RiderController;
use App\Http\Middleware\HasRestaurant;
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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

/**
 *Auth
*/
Route::group(['prefix' => 'v1'], function() {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
});

Route::group(['prefix' => 'v1', 'middleware' => 'auth:sanctum'], function() {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'authUser']);

    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::get('/notifications/{notification}/mark-read', [NotificationController::class, 'markAsRead']);
    Route::get('/notifications/all/read', [NotificationController::class, 'markAllAsRead']);
});
/**Basically a customer who will be ordering food/drinks */
Route::group(['prefix' => 'v1/orderer', 'middleware' => 'auth:sanctum'], function() {
    Route::get('/groceries', [MenuController::class, 'groceries']);
    Route::apiResource('orderers', OrdererController::class);

    Route::apiResource('orderer-restaurants', RestaurantController::class);
    Route::apiResource('orderer-food-categories', FoodCommonCategoryController::class);
    Route::apiResource('orderer-food-sub-categories', FooSubCategoryController::class);

    Route::apiResource('orderer-menu', MenuController::class);

    Route::apiResource('menu-bookmark', MenuBookmarkController::class)->except(['update']);
    Route::apiResource('restaurant-bookmark', RestaurantBookmarkController::class)->except(['update']);

    Route::apiResource('cart', CartController::class)->except(['update']);
    Route::apiResource('cart-items', CartItemController::class);

    Route::apiResource('orders', OrderController::class)->except(['update']);

    // Route::apiResource('payment', PaymentController::class)->except(['update']);
});

Route::group(['prefix' => 'v1/rider', 'middleware' => 'auth:sanctum'], function() {
    Route::post('/profile/create', [RiderController::class, 'create']);
    Route::post('/profile/update', [RiderController::class, 'update']);
    Route::get('/profile', [RiderController::class, 'profile']);
    Route::get('/orders', [RiderController::class, 'orders']);
    Route::post('/orders/update', [RiderController::class, 'updateOrder']);
    Route::post('/orders/{order_id}/delivery/location/update', [RiderController::class, 'updateDeliveryLocation'])->middleware(['throttle:location']);
    Route::post('/location/update', [RiderController::class, 'updateLocation']);
});

Route::get('/v1/orderer/payment/{user_id}/{order_id}', [PaymentController::class, 'store']);

/**Restaurant owners management */
Route::group(['prefix' => 'v1/restaurant', 'middleware' => 'auth:sanctum'], function() {
    Route::post('/restaurant', [RestaurantController::class, 'store']);
    Route::middleware(['has_restaurant'])->group(function () {
        Route::get('/dashboard', [RestaurantController::class, 'dashboard']);
        Route::apiResource('restaurants', RestaurantController::class);
        Route::post('/restaurants/{restaurant}/update', [RestaurantController::class, 'update']);
        Route::apiResource('food-categories', FoodCommonCategoryController::class);
        Route::apiResource('food-sub-categories', FooSubCategoryController::class);
        Route::post('food-sub-categories/bulk', [FooSubCategoryController::class, 'bulkStore']);
        Route::apiResource('more-info', QuestionnaireController::class);

        Route::apiResource('menu', MenuController::class);
        Route::post('/{id}/menu/add', [MenuController::class, 'store']);
        Route::post('/menu/{id}/update', [MenuController::class, 'update']);
        Route::post('/menu/{id}/images/update', [MenuController::class, 'updateImages']);
        Route::apiResource('menu-prices', MenuPriceController::class);
        Route::post('/menu-prices/{id}/update', [MenuPriceController::class, 'update']);
        Route::delete('/menu-prices/{id}/delete', [MenuPriceController::class, 'destroy']);

        Route::get('/orders/{order}', [OrderController::class, 'show']);
        Route::apiResource('orders', OrderController::class)->except(['store']);
        Route::post('/orders/{order}/update', [OrderController::class, 'update']);
        Route::post('/orders/assign', [OrderController::class, 'assignorder']);

        Route::get('/riders/{id}', [RestaurantController::class, 'riders']);

        Route::get('/payments', [RestaurantController::class, 'payments']);

        Route::get('/restaurant/{restaurant}/payments', [RestaurantController::class, 'restaurantPayments']);
        Route::get('/restaurant/{restaurant}/orders', [RestaurantController::class, 'restaurantOrders']);
        Route::get('/restaurant/{restaurant}/menu', [RestaurantController::class, 'restaurantMenu']);

        Route::get('{restaurant}/categories', [RestaurantController::class, 'categories']);
        Route::post('{restaurant}/categories/add', [RestaurantController::class, 'addCategory']);
        Route::post('{restaurant}/categories/{id}/update', [RestaurantController::class, 'updateCategory']);

        // Employees
        Route::group(['prefix' => 'employees',], function () {
            Route::get('/', [RestaurantController::class, 'employees']);
            Route::get('/{restaurant}', [RestaurantController::class, 'restaurantEmployees']);
            Route::post('/{restaurant}/add', [RestaurantController::class, 'addEmployee']);
            Route::post('/{user}/update', [RestaurantController::class, 'updateEmployee']);
        });

        // Operating Hours
        Route::get('/{id}/operating-hours', [RestaurantOperatingHoursController::class, 'index']);
        Route::post('/{uuid}/operating-hours', [RestaurantOperatingHoursController::class, 'store']);
        Route::post('/{uuid}/operating-hours/update', [RestaurantOperatingHoursController::class, 'update']);

        // Documents
        Route::get('/{id}/documents', [RestaurantDocumentsController::class, 'index']);
        Route::post('/{uuid}/documents/store', [RestaurantDocumentsController::class, 'store']);
        Route::post('/{uuid}/documents/update', [RestaurantDocumentsController::class, 'update']);

        Route::get('/documents/{id}/download', [RestaurantDocumentsController::class, 'download']);
    });
});

Route::post('/v1/order/payment/create-paypal-order', [PaymentController::class, 'createPaypalOrder']);
Route::post('/v1/order/payment/capture-paypal-order', [PaymentController::class, 'capturePaypalPayment']);

// Route::group(['prefix' => 'v1/customer', 'middleware' => 'auth:sanctum'], function() {
//     // Define customer-specific routes here
// });
// Route::group(['prefix' => 'v1/driver', 'middleware' => 'auth:sanctum'], function() {
//     // Define driver-specific routes here
// });
// Route::group(['prefix' => 'v1/admin', 'middleware' => 'auth:sanctum'], function() {
//     // Define admin-specific routes here
// });

require __DIR__.'/admin.php';
