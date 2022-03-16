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

Route::get('/ping', function(){
    return ['pong' => true];
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::prefix('client')->group(function(){
//     Route::apiResource('/', ClientController::class);
// });

Route::apiResource('company', CompanyController::class);
Route::apiResource('clients', ClientController::class);
Route::apiResource('categorie', CategorieController::class);
Route::apiResource('carts', CartController::class);
Route::apiResource('products', ProductController::class);
Route::apiResource('cheks', ChekController::class);
Route::apiResource('sales', SaleController::class);
Route::apiResource('address', AddressController::class);
Route::apiResource('units', UnitController::class);






