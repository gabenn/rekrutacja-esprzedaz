<?php

use App\Http\Controllers\PetController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PetController::class, 'index']);

Route::get('/create', [PetController::class, 'create']);

Route::get('/edit/{pet}', [PetController::class, 'edit']);


