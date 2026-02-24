<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CeilingController;
use App\Http\Controllers\ManufacturerController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CeilingController::class, 'index'])->name('home');
Route::get('/ceilings/{id}', [CeilingController::class, 'show'])->name('ceiling.show');
Route::get('/about', [PageController::class, 'about'])->name('about');

Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/manufacturers/{id}', [ManufacturerController::class, 'show'])->name('manufacturers.show');
