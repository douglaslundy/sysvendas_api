<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ClientController;
use App\Http\Controllers\Api\V1\SaleController;
use App\Http\Controllers\Api\V1\CartController;
use App\Http\Controllers\Api\V1\CategorieController;
use App\Http\Controllers\Api\V1\CompanyController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\ChekController;
use App\Http\Controllers\Api\V1\UnitController;
use App\Http\Controllers\Api\V1\AddressController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\AuthController;

Route::get('/ping', function () {
    return ['pong' => true];
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/401', [AuthController::class, 'unauthorized'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Route::apiResource('auth', AuthController::class);

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/validate', [AuthController::class, 'validateToken']);

    Route::apiResource('company', CompanyController::class);
    Route::apiResource('clients', ClientController::class);
    Route::apiResource('categorie', CategorieController::class);
    Route::apiResource('carts', CartController::class);
    Route::apiResource('products', ProductController::class);
    Route::apiResource('cheks', ChekController::class);
    Route::apiResource('sales', SaleController::class);
    Route::apiResource('address', AddressController::class);
    Route::apiResource('units', UnitController::class);
    Route::apiResource('users', UserController::class);
});

// Route::apiResource('clients', ClientController::class);
// Route::apiResource('categorie', CategorieController::class);
// Route::apiResource('carts', CartController::class);
// Route::apiResource('products', ProductController::class);
// Route::apiResource('cheks', ChekController::class);
// Route::apiResource('sales', SaleController::class);
// Route::apiResource('address', AddressController::class);
// Route::apiResource('units', UnitController::class);
// Route::apiResource('users', UserController::class);
