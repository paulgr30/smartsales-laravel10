<?php

use App\Http\Controllers\{
    CategoryController,
    CustomerController,
    IdentityDocumentController,
    OrderController,
    OrderStatusController,
    ProductController,
    QuoteController,
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




// Categories
Route::get('categories', [CategoryController::class, 'getAll']);
Route::get('categories/bycriteria', [CategoryController::class, 'getByCriteria']);
Route::post('categories', [CategoryController::class, 'store']);
Route::put('categories/{category}', [CategoryController::class, 'update']);
Route::patch('categories/{category}', [CategoryController::class, 'toggleStatus']);
Route::delete('categories/{category}', [CategoryController::class, 'destroy']);


// Units
Route::get('units', [UnitController::class, 'getAll']);
Route::get('units/bycriteria', [UnitController::class, 'getByCriteria']);
Route::post('units', [UnitController::class, 'store']);
Route::put('units/{unit}', [UnitController::class, 'update']);
Route::patch('units/{unit}', [UnitController::class, 'toggleStatus']);
Route::delete('units/{unit}', [UnitController::class, 'destroy']);


// IdentityDocument
Route::get('identitydocuments', [IdentityDocumentController::class, 'getAll']);
Route::get('identitydocuments/bycriteria', [IdentityDocumentController::class, 'getByCriteria']);
Route::post('identitydocuments', [IdentityDocumentController::class, 'store']);
Route::put('identitydocuments/{identityDocument}', [IdentityDocumentController::class, 'update']);
Route::patch('identitydocuments/{identityDocument}', [IdentityDocumentController::class, 'toggleStatus']);
Route::delete('identitydocuments/{identityDocument}', [IdentityDocumentController::class, 'destroy']);


// Product
Route::get('products', [ProductController::class, 'getAll']);
Route::get('products/bycriteria', [ProductController::class, 'getByCriteria']);
Route::post('products', [ProductController::class, 'store']);
Route::put('products/{product}', [ProductController::class, 'update']);
Route::patch('products/{product}', [ProductController::class, 'toggleStatus']);
Route::delete('products/{product}', [ProductController::class, 'destroy']);


// Users
Route::get('users', [CustomerController::class, 'getAll']);
Route::get('users/bycriteria', [CustomerController::class, 'getByCriteria']);
Route::get('users/bynumberid', [CustomerController::class, 'getByNumberId']);
Route::post('users', [CustomerController::class, 'store']);
Route::put('users/{user}', [CustomerController::class, 'update']);
Route::delete('users/{user}', [CustomerController::class, 'destroy']);


// Statuses
Route::get('statuses', [OrderStatusController::class, 'getAll']);


// Orders
Route::get('orders', [OrderController::class, 'getAll']);
Route::get('orders/bycriteria', [OrderController::class, 'getByCriteria']);
Route::post('orders', [OrderController::class, 'store']);
Route::put('orders/{order}', [OrderController::class, 'update']);
Route::patch('orders/{order}', [OrderController::class, 'canceled']);
