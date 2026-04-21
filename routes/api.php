<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\apicontroller;
use App\Http\Controllers\subapicontroller;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/category', [apicontroller::class, 'index']);
Route::post('/category/save', [apicontroller::class, 'store']);
Route::put('/category/{id}/update', [apicontroller::class, 'update']);
Route::patch('/category/{id}/edit', [apicontroller::class, 'edit']);
Route::delete('/category/{id}/delete', [apicontroller::class, 'destroy']);

Route::get('/subcategory', [subapicontroller::class, 'index']);
Route::post('/subcategory/save', [subapicontroller::class, 'store']);
Route::put('/subcategory/{id}/update', [subapicontroller::class, 'update']);
Route::patch('/subcategory/{id}/edit', [subapicontroller::class, 'edit']);
Route::delete('/subcategory/{id}/delete', [subapicontroller::class, 'destroy']);
