<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
//use App\Http\Controllers\EquipmentController;
//use App\Http\Controllers\LoanController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    return file_get_contents(public_path('index.html'));
});

// Esto genera automáticamente las 5 rutas del CRUD de golpe
Route::apiResource('usuarios', UsuarioController::class);
//Route::apiResource('equipments', EquipmentController::class);
//Route::apiResource('loans', LoanController::class);


