<?php

use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\Api\ProfilwebController;
use Illuminate\Support\Facades\Route;


// Route::middleware('auth:api')->get('/users', [UserController::class, 'index']);
Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'create']);


//LOGIN
Route::Post('register',RegisterController::class);
Route::post('login', LoginController::class);
Route::post('logout', LogoutController::class);

// //profilwebb

Route::get('profilweb', [ProfilWebController::class, 'index']);
Route::post('profilweb', [ProfilWebController::class, 'store']);
Route::delete('profilweb', [ProfilWebController::class, 'destroy']);

// //Contact
Route::get('/pesan', [MessageController::class, 'index']);
Route::get('/pesan/{id}', [MessageController::class, 'show']);
Route::post('/pesan', [MessageController::class, 'store']);
Route::delete('/pesan/{id}', [MessageController::class, 'destroy']);

//gallery
Route::get('/galleries', [GalleryController::class, 'index']);
Route::get('/galleries/{id}', [GalleryController::class, 'show']);
Route::post('/galleries', [GalleryController::class, 'store']);
Route::post('/galleries/{id}', [GalleryController::class, 'update']);
Route::delete('/galleries/{id}', [GalleryController::class, 'destroy']);

// //location
Route::get('/locations', [LocationController::class, 'index']);
Route::get('/locations/{id}', [LocationController::class, 'show']);
Route::post('/locations', [LocationController::class, 'store']);
Route::post('/locations/{id}', [LocationController::class, 'update']);
Route::delete('/locations/{id}', [LocationController::class, 'destroy']);


