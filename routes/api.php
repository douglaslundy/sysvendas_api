<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\ClientController;
use App\Http\Controllers\api\v1\CartController;



Route::get('/ping', function(){
    return ['pong' => true];
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('client')->group(function(){
    Route::get('/', [ClientController::class, 'index']);
});


Route::get('/cart', [CartController::class, 'index']);

