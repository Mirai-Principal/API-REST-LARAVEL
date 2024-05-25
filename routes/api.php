<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\estudianteController;



Route::get('/estudiantes', [estudianteController::class, 'readAll']);

Route::get('/estudiantes/{id}', [estudianteController::class, 'readOne']);

Route::post('/estudiantes', [estudianteController::class, 'insert']);

Route::put('/estudiantes/{id}', [estudianteController::class, 'update']);

Route::patch('/estudiantes/{id}', [estudianteController::class, 'updatePartial']);

Route::delete( 'estudiantes/{id}', [estudianteController::class, 'delete']);


// route::redirect('/estudiantes', '/users');