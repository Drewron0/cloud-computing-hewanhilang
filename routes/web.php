<?php

use App\Http\Controllers\AnimalController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AnimalController::class, 'index'])->name('animals.index');
Route::post('/animals', [AnimalController::class, 'store'])->name('animals.store');
