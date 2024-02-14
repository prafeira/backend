<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\VendaController;
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

// Rotas de Autenticação/Cadastro
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/cadastro', [PessoaController::class, 'cadastro']);

// Rota para obter a versão do Laravel
Route::get('/version', function () {
    $laravel = app();
    return "Laravel na versao:". $laravel::VERSION;
});

// Rotas protegidas pelo middleware 'auth:sanctum'
Route::middleware('auth:sanctum')->group(function () {

    // Rota para obter informações do usuário autenticado
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
    Route::get('/token', [AuthenticatedSessionController::class, 'getToken']);
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
    Route::prefix('/pessoas')->group(function () {
        Route::get('/', [PessoaController::class, 'index']);
        Route::post('/', [PessoaController::class, 'store']);
        Route::put('/{id}', [PessoaController::class, 'update']);
        Route::delete('/{id}', [PessoaController::class, 'destroy']);
        Route::get('/{id}', [PessoaController::class, 'show']);
    });


    // Grupo de rotas relacionadas a Vendas
    Route::prefix('/vendas')->group(function () {
        Route::get('/', [VendaController::class, 'index']);
        Route::post('/', [VendaController::class, 'store']);
        Route::put('/{id}', [VendaController::class, 'update']);
        Route::delete('/{id}', [VendaController::class, 'destroy']);
        Route::get('/{id}', [VendaController::class, 'show']);
        Route::get('/porPessoa/{idPessoa}', [VendaController::class, 'listarVendasPorPessoa']);
        Route::get('/porEmpresa/{idEmpresa}', [VendaController::class, 'listarVendasPorEmpresa']);
    });
});
