<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Administracion\UserController;
use App\Http\Controllers\Administracion\RolesController;
use App\Http\Controllers\Administracion\PermissionController;
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
Route::post('/administracion/usuario/setEditarRolByUsuario', [UserController::class, 'setEditarRolByUsuario']);

Route::get('/administracion/rol/getListarRoles', [RolesController::class, 'getListarRoles']);
Route::get('/administracion/rol/getListarPermisosByRol', [RolesController::class, 'getListarPermisosByRol']);



Route::post('/administracion/rol/setRegistrarRolPermisos', [RolesController::class, 'setRegistrarRolPermisos']);
Route::post('/administracion/rol/setEditarRolPermisos', [RolesController::class, 'setEditarRolPermisos']);


Route::post('/archivo/setRegistrarArchivo', [FilesController::class, 'setRegistrarArchivo']);
Route::get('/administracion/permiso/getListarPermisos', [PermissionController::class, 'getListarPermisos']);
Route::post('/administracion/permiso/setRegistrarPermiso', [PermissionController::class, 'setRegistrarPermiso']);
Route::post('/administracion/permiso/setEditarPermiso', [PermissionController::class, 'setEditarPermiso']);


Route::get('/{optional?}', function () {
    return view('app');
})->name('basepath')
->where('optional','.*');
