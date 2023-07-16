<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;


//backend method route for auth or page route
Route::post('/userLogin', [UserController::class, 'userLogin']);
Route::post('/userRegister', [UserController::class, 'userRegister']);
Route::post('/OTPToMail', [UserController::class, 'OTPToMail']);
Route::post('/OTPVarified', [UserController::class, 'OTPVarified']);
Route::post('/setPassword', [UserController::class, 'setPassword']);
Route::post('/profileUpdate', [UserController::class, 'profileUpdate']);



// fontend method route for auth or API route

Route::get('/userLogin',[UserController::class,'LoginPage']);
Route::get('/userRegistration',[UserController::class,'RegistrationPage']);
Route::get('/sendOtp',[UserController::class,'SendOtpPage']);
Route::get('/verifyOtp',[UserController::class,'VerifyOTPPage']);
Route::get('/resetPassword',[UserController::class,'ResetPasswordPage']);


//DashboardController
 
Route::get('/dashboard',[DashboardController::class,'DashboardPage']);

