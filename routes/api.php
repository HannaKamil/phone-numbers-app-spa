<?php

use App\Http\Controllers\PhoneNumberController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');



Route::get('/phone-numbers', [PhoneNumberController::class, 'index'])->name('phone_numbers.index');
Route::get('/countries', [PhoneNumberController::class, 'getCountries']);
