<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\ClientController;
use App\Http\Controllers\api\v1\SaleController;
use App\Http\Controllers\api\v1\CartController;



Route::get('/ping', function(){
    return ['pong' => true];
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::prefix('client')->group(function(){
//     Route::apiResource('/', ClientController::class);
// });


Route::apiResource('clients', ClientController::class);
Route::apiResource('carts', CartController::class);
// Route::apiResource('sales', SaleController::class);
// Route::apiResource('adress', AddressController::class);
// Route::apiResource('units', UnitController::class);
// Route::apiResource('categories', CategorieController::class);
// Route::apiResource('produtcts', ProductController::class);
// Route::apiResource('cheks', ChekController::class);
// Route::apiResource('company', CompanyController::class);






