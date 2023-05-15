<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\ClientController;
use App\Http\Controllers\api\v1\SaleController;
use App\Http\Controllers\api\v1\CartController;
use App\Http\Controllers\api\v1\CategorieController;
use App\Http\Controllers\api\v1\CompanyController;
use App\Http\Controllers\api\v1\ProductController;
use App\Http\Controllers\api\v1\ChekController;
use App\Http\Controllers\api\v1\UnitController;
use App\Http\Controllers\api\v1\AddressController;
use App\Http\Controllers\api\v1\UserController;
use App\Http\Controllers\api\v1\AuthController;
use App\Http\Controllers\api\v1\BudgetController;

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
    Route::apiResource('cart', CartController::class);
    Route::delete('cart/drop/{id_user}', [CartController::class, 'dropProductsPerUser']);

    Route::apiResource('products', ProductController::class);
    Route::post('products/updateValueCategories', [ProductController::class, 'updateValueCategories']);

    Route::apiResource('cheks', ChekController::class);

    Route::apiResource('sales', SaleController::class);
    Route::get('sales/salesPerClient/{id_client}/{paied}', [SaleController::class, 'salesPerClient']);
    Route::post('sales/pay', [SaleController::class, 'paySale']);

    Route::apiResource('address', AddressController::class);
    Route::apiResource('units', UnitController::class);
    Route::apiResource('users', UserController::class);

    Route::apiResource('budgets', BudgetController::class);
    Route::get('budgets/budgetsPerClient/{id_client}', [BudgetController::class, 'budgetsPerClient']);
});
