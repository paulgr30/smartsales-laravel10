<?php

use App\Http\Controllers\{
    AuthController,
    CategoryController,
    CustomerController,
    IdentityDocumentController,
    OrderController,
    OrderStatusController,
    ProductController,
    UnitController
};;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/




// Autenticacion
Route::post('auth/login', [AuthController::class, 'login'])->name('auth.login');

//middleware('jwt.auth')->
Route::middleware('jwt.auth')->controller(AuthController::class)->prefix('auth')
    ->group(
        function () {
            Route::get('profile', 'getProfile')->name('auth.profile');
            Route::put('profile/update', 'updateProfile')->name('auth.profile.update');
            Route::post('password/change', 'changePassword')->name('auth.password.change');
            Route::post('token/refresh', 'refreshToken')->name('auth.token.refresh');
            Route::post('logout', 'logout')->name('auth.logout');
        }
    );




// Categories
Route::middleware('jwt.auth')->controller(CategoryController::class)
    ->group(
        function () {
            Route::get('categories', 'getAll')->name('categories.all');
            Route::get('categories/bycriteria', 'getByCriteria')->name('categories.bycriteria');
            Route::post('categories', 'store')->name('categories.store');
            Route::put('categories/{category}', 'update')->name('categories.update');
            Route::patch('categories/{category}', 'toggleStatus')->name('categories.toggle.status');
            Route::delete('categories/{category}', 'destroy')->name('categories.destroy');
        }
    );


// Units
Route::middleware('jwt.auth')->controller(UnitController::class)
    ->group(
        function () {
            Route::get('units', 'getAll');
            Route::get('units/bycriteria', 'getByCriteria');
            Route::post('units', 'store');
            Route::put('units/{unit}', 'update');
            Route::patch('units/{unit}', 'toggleStatus');
            Route::delete('units/{unit}', 'destroy');
        }
    );


// IdentityDocument
Route::middleware('jwt.auth')->controller(IdentityDocumentController::class)
    ->group(
        function () {
            Route::get('identitydocuments', 'getAll');
            Route::get('identitydocuments/bycriteria', 'getByCriteria');
            Route::post('identitydocuments', 'store');
            Route::put('identitydocuments/{identityDocument}', 'update');
            Route::patch('identitydocuments/{identityDocument}', 'toggleStatus');
            Route::delete('identitydocuments/{identityDocument}', 'destroy');
        }
    );


// Product
Route::middleware('jwt.auth')->controller(IdentityDocumentController::class)
    ->group(
        function () {
            Route::get('products', [ProductController::class, 'getAll']);
            Route::get('products/bycriteria', [ProductController::class, 'getByCriteria']);
            Route::post('products', [ProductController::class, 'store']);
            Route::put('products/{product}', [ProductController::class, 'update']);
            Route::patch('products/{product}', [ProductController::class, 'toggleStatus']);
            Route::delete('products/{product}', [ProductController::class, 'destroy']);
        }
    );


// Users
Route::middleware('jwt.auth')->controller(CustomerController::class)
    ->group(
        function () {
            Route::get('users', 'getAll');
            Route::get('users/bycriteria', 'getByCriteria');
            Route::get('users/bynumberid', 'getByNumberId');
            Route::post('users', 'store');
            Route::put('users/{user}', 'update');
            Route::delete('users/{user}', 'destroy');
        }
    );


// Statuses
Route::middleware('jwt.auth')->controller(OrderStatusController::class)
    ->group(
        function () {
            Route::get('statuses', 'getAll');
        }
    );


// Orders
Route::middleware('jwt.auth')->controller(OrderController::class)
    ->group(
        function () {
            Route::get('orders', 'getAll');
            Route::get('orders/bycriteria', 'getByCriteria');
            Route::post('orders', 'store');
            Route::put('orders/{order}', 'update');
            Route::patch('orders/{order}', 'canceled');
        }
    );
