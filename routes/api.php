<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\MasterChallengeController;
use App\Http\Controllers\FinancialProfileController;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//routing aset
Route::get('/assets', [AssetController::class, 'index']);
Route::get('/assets/{id}', [AssetController::class, 'show']);
Route::post('/assets', [AssetController::class, 'store']);
Route::put('/assets/{id}', [AssetController::class, 'update']);
Route::delete('/assets/{id}', [AssetController::class, 'destroy']);

//routing financial profile
Route::get('/financial-profiles', [FinancialProfileController::class, 'index']);
Route::post('/financial-profiles', [FinancialProfileController::class, 'store']);
Route::get('/financial-profiles/{id}', [FinancialProfileController::class, 'show']);
Route::put('/financial-profiles/{id}', [FinancialProfileController::class, 'update']);
Route::delete('/financial-profiles/{id}', [FinancialProfileController::class, 'destroy']);

//routing users
Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);