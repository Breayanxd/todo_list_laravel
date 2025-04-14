<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post("/register", [AuthController::class,"register"]);
Route::post("/login", [AuthController::class,"login"]);


Route::middleware("auth:sanctum")->group(function () {
    //Auth
    Route::get("/profile", [AuthController::class,"profile"]);
    Route::post("/logout", [AuthController::class,"logout"]);

    //User incomplete
    Route::delete("/users/{id}", [UserController::class,"destroy"]);

    //Tasks
    

});


