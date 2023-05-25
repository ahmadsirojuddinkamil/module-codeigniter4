<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(UserController::class)->group(function () {
    Route::get('/user', 'index');
    Route::get('/user/create', 'create');
    Route::post('/user/store', 'store');
    Route::get('/user/{uuid}', 'show');
    Route::get('/user/edit/{uuid}', 'edit');
    Route::put('/user/update', 'update');
    Route::delete('/user/delete/{uuid}', 'delete');
});
