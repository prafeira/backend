<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::get('/empresas', [EmpresaController::class, 'index']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/version', function () {
    $laravel = app();
    return "Laravel na versao:". $laravel::VERSION;
});

Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
    // Rotas relacionadas à empresa
    // Route::get('/empresas', [EmpresaController::class, 'index']);
    Route::get('/empresas/{id}', [EmpresaController::class, 'show']);
    Route::get('/empresas/create', [EmpresaController::class, 'create']);
    Route::post('/empresas', [EmpresaController::class, 'store']);
    Route::get('/empresas/{id}/edit', [EmpresaController::class, 'edit']);
    Route::put('/empresas/{id}', [EmpresaController::class, 'update']);
    Route::delete('/empresas/{id}', [EmpresaController::class, 'destroy']);
});

// PESSOA 
Route::get('/pessoa', [EmpresaController::class, 'getPessoa']);
