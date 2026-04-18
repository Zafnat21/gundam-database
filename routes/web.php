<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GundamController;

Route::get('/', [GundamController::class, 'index']);