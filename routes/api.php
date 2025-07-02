<?php
use App\Http\Controllers\Api\LibrettoController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('libretto', LibrettoController::class);
});

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');