<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Administracion\UserController;
use App\Http\Controllers\FilesController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/administracion/usuarios/getListaUsuarios', [UserController::class, 'getListaUsuarios']);
Route::post('/administracion/usuario/setRegistrarUsuario', [UserController::class, 'setRegistrarUsuario']);
Route::post('/administracion/usuario/setEditarUsuario', [UserController::class, 'setEditarUsuario']);
Route::post('/administracion/usuario/setCambiarEstadoUsuario', [UserController::class, 'setCambiarEstadoUsuario']);
Route::post('/archivo/setRegistrarArchivo', [FilesController::class, 'setRegistrarArchivo']);


Route::get('/{optional?}', function () {
    return view('app');
})->name('basepath')
->where('optional','.*');
