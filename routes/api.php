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

// Rotas de Autenticação
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// Rota para obter a versão do Laravel
Route::get('/version', function () {
    $laravel = app();
    return "Laravel na versao:". $laravel::VERSION;
});

// Rotas protegidas pelo middleware 'auth:sanctum'
Route::middleware('auth:sanctum')->group(function () {

    // Rota para obter informações do usuário autenticado
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Grupo de rotas relacionadas a Empresas
    Route::prefix('/empresas')->group(function () {
        Route::get('/', [EmpresaController::class, 'index']);
        Route::post('/', [EmpresaController::class, 'store']);
        Route::put('/{id}', [EmpresaController::class, 'update']);
        Route::delete('/{id}', [EmpresaController::class, 'destroy']);
        Route::get('/{id}', [EmpresaController::class, 'show']);
    });

    // Grupo de rotas relacionadas a Pessoas
    Route::prefix('/pessoa')->group(function () {
        Route::get('/', [EmpresaController::class, 'getPessoa']);
        // Adicione outras rotas de Pessoa conforme necessário
    });

});
