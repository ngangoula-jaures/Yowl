<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get("/EmailVerify", [AuthController::class, "showVerifyEmail"])->name("verify.email");
Route::post("/EmailVerify", [AuthController::class, "verifyEmailStepOne"])->name('post.emailVerify');

Route::get("/verify-code", [AuthController::class, "showVerifyCode"])->name("verify.code")->middleware(\App\Http\Middleware\hasVerifyEmail::class);
Route::post("/verify-code", [AuthController::class, "verifyCode"])->name('post.verifyCode')->middleware(\App\Http\Middleware\hasVerifyEmail::class);

Route::get("/inscription", [AuthController::class, "showRegister"])->name("register")->middleware(\App\Http\Middleware\hasVerifyEmail::class);
Route::post("/inscription", [AuthController::class, "register"])->name('post.inscription')->middleware(\App\Http\Middleware\hasVerifyEmail::class);

Route::get("/login", [AuthController::class, "showLogin"])->name("login");
Route::post("/login", [AuthController::class, "authenticate"])->name('post.login');

Route::middleware("auth")->group(function(){
    Route::post("/logout", [AuthController::class, "logout"])->name("logout");
});