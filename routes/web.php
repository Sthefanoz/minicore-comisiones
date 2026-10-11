<?php

use App\Http\Controllers\ComisionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ComisionController::class, 'index'])->name('comisiones.index');
