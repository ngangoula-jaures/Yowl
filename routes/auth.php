<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get("/EmailVerify", [AuthController::class, "showVerifyEmail"])->name("verify.email");
Route::post("/EmailVerify", [AuthController::class, "verifyEmailStepOne"]);

Route::get("/verify-code", [AuthController::class, "showVerifyCode"])->name("verify.code");
Route::post("/verify-code", [AuthController::class, "verifyCode"]);

Route::get("/inscription", [AuthController::class, "showRegister"])->name("register");
Route::post("/inscription", [AuthController::class, "register"]);

Route::get("/login", [AuthController::class, "showLogin"])->name("login");
Route::post("/login", [AuthController::class, "authenticate"]);

Route::middleware("auth")->group(function(){
    // Route::get("/", function () {
    //     return inertia("Home");
    // })->name("home");

    Route::post("/logout", [AuthController::class, "logout"])->name("logout");
});