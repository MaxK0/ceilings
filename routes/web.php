<?php

use App\Http\Controllers\CeilingController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CeilingController::class, 'index'])->name('home');
Route::get('/ceiling/{id}', [CeilingController::class, 'show'])->name('ceiling.show');
Route::get('/about', [PageController::class, 'about'])->name('about');
