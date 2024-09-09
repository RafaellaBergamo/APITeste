<?php

use App\Http\Controllers\Usuario;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\UsuariosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('usuarios')->group(function() {
    Route::get('/', [UsuarioController::class, 'buscar']);
    Route::get('/{id}', [UsuarioController::class, 'buscarPorId']);
    Route::get('/exportar/pdf', [UsuarioController::class, 'exportar']);
    Route::post('/', [UsuarioController::class, "cadastrar"]);
    Route::put('/{id}', [UsuarioController::class, 'atualizar']);
    Route::put('{id}/desativar', [UsuarioController::class, 'desativar']);
});
