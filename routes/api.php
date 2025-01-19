<?php

use App\Http\Controllers\PetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::resource('pets', PetController::class);

Route::get('/pets/status/{status}', [PetController::class, 'getPetsByStatus']);
