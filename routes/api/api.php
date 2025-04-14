<?php

use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;


Route::post('register', [UserController::class, 'register'])->name('register');
Route::post('login', [UserController::class, 'login'])->name('login');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('logout', [UserController::class, 'logout'])->name('logout');
});
