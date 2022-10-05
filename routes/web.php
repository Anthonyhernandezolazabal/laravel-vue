<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilesController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Administracion\UserController;
use App\Http\Controllers\Administracion\RolesController;
use App\Http\Controllers\Administracion\PermissionController;

Route::post('/authenticate/login', [LoginController::class, 'login']);

Route::group(['middleware' => ['auth']], function () {
    Route::post('/authenticate/logout', [LoginController::class, 'logout']);
    Route::get('/authenticate/getRefrescarUsuarioAutenticado', function () {
        return Auth::user()->load("file");
    });
    Route::get('/administracion/usuarios/getListaUsuarios', [UserController::class, 'getListaUsuarios']);
    Route::post('/administracion/usuario/setRegistrarUsuario', [UserController::class, 'setRegistrarUsuario']);
    Route::post('/administracion/usuario/setEditarUsuario', [UserController::class, 'setEditarUsuario']);
    Route::post('/administracion/usuario/setCambiarEstadoUsuario', [UserController::class, 'setCambiarEstadoUsuario']);
    Route::post('/administracion/usuario/setEditarRolByUsuario', [UserController::class, 'setEditarRolByUsuario']);
    Route::get('/administracion/usuario/getRolByUsuario', [UserController::class, 'getRolByUsuario']);
    Route::get('/administracion/usuario/getListarPermisosByRolAsignado', [UserController::class, 'getListarPermisosByRolAsignado']);
    Route::get('/administracion/usuario/getListarPermisosByUsuario', [UserController::class, 'getListarPermisosByUsuario']);
    Route::post('/administracion/usuario/setRegistrarPermisosByUsuario', [UserController::class, 'setRegistrarPermisosByUsuario']);
    Route::get('/administracion/usuario/getListarRolPermisosByUsuario', [UserController::class, 'getListarRolPermisosByUsuario']);
    Route::get('/administracion/rol/getListarRoles', [RolesController::class, 'getListarRoles']);
    Route::get('/administracion/rol/getListarPermisosByRol', [RolesController::class, 'getListarPermisosByRol']);
    Route::post('/administracion/rol/setRegistrarRolPermisos', [RolesController::class, 'setRegistrarRolPermisos']);
    Route::post('/administracion/rol/setEditarRolPermisos', [RolesController::class, 'setEditarRolPermisos']);
    Route::post('/archivo/setRegistrarArchivo', [FilesController::class, 'setRegistrarArchivo']);
    Route::get('/administracion/permiso/getListarPermisos', [PermissionController::class, 'getListarPermisos']);
    Route::post('/administracion/permiso/setRegistrarPermiso', [PermissionController::class, 'setRegistrarPermiso']);
    Route::post('/administracion/permiso/setEditarPermiso', [PermissionController::class, 'setEditarPermiso']);
});




Route::get('/{optional?}', function () {
    return view('app');
})->name('basepath')
->where('optional','.*');

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
