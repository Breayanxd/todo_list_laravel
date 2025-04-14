<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');*/

/*Route::group(['prefix' => 'users'], function () {
    Route::post('/', [UserController::class, 'store']);
});*/

Route::post("/register", [AuthController::class,"register"]);
Route::post("/login", [AuthController::class,"login"]);
Route::post("/logout", [AuthController::class,"logout"]);
Route::delete("/users/{id}", [UserController::class,"destroy"]);

