<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilesController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Administracion\UsersController;
use App\Http\Controllers\Administracion\RolesController;
use App\Http\Controllers\Administracion\PermissionController;
use App\Http\Controllers\Configuracion\CategoriaController;
use App\Http\Controllers\Configuracion\ProductoController;
use App\Http\Controllers\Configuracion\ColorproductosController;

Route::post('/authenticate/login', [LoginController::class, 'login']);

Route::group(['middleware' => ['auth']], function () {
    Route::post('/authenticate/logout', [LoginController::class, 'logout']);
    Route::get('/authenticate/getRefrescarUsuarioAutenticado', function () {
        return Auth::user()->load("file");
    });
    Route::get('/administracion/usuarios/getListaUsuarios', [UsersController::class, 'getListaUsuarios']);
    Route::post('/administracion/usuario/setRegistrarUsuario', [UsersController::class, 'setRegistrarUsuario']);
    Route::post('/administracion/usuario/setEditarUsuario', [UsersController::class, 'setEditarUsuario']);
    Route::post('/administracion/usuario/setCambiarEstadoUsuario', [UsersController::class, 'setCambiarEstadoUsuario']);
    Route::post('/administracion/usuario/setEditarRolByUsuario', [UsersController::class, 'setEditarRolByUsuario']);
    Route::get('/administracion/usuario/getRolByUsuario', [UsersController::class, 'getRolByUsuario']);
    Route::get('/administracion/usuario/getListarPermisosByRolAsignado', [UsersController::class, 'getListarPermisosByRolAsignado']);
    Route::get('/administracion/usuario/getListarPermisosByUsuario', [UsersController::class, 'getListarPermisosByUsuario']);
    Route::post('/administracion/usuario/setRegistrarPermisosByUsuario', [UsersController::class, 'setRegistrarPermisosByUsuario']);
    Route::get('/administracion/usuario/getListarRolPermisosByUsuario', [UsersController::class, 'getListarRolPermisosByUsuario']);
    Route::get('/administracion/rol/getListarRoles', [RolesController::class, 'getListarRoles']);
    Route::get('/administracion/rol/getListarPermisosByRol', [RolesController::class, 'getListarPermisosByRol']);
    Route::post('/administracion/rol/setRegistrarRolPermisos', [RolesController::class, 'setRegistrarRolPermisos']);
    Route::post('/administracion/rol/setEditarRolPermisos', [RolesController::class, 'setEditarRolPermisos']);
    Route::post('/archivo/setRegistrarArchivo', [FilesController::class, 'setRegistrarArchivo']);
    Route::get('/administracion/permiso/getListarPermisos', [PermissionController::class, 'getListarPermisos']);
    Route::post('/administracion/permiso/setRegistrarPermiso', [PermissionController::class, 'setRegistrarPermiso']);
    Route::post('/administracion/permiso/setEditarPermiso', [PermissionController::class, 'setEditarPermiso']);


    Route::get('/configuracion/categoria/getListarCategorias', [CategoriaController::class, 'getListarCategorias']);
    Route::post('/configuracion/categoria/setRegistrarCategoria', [CategoriaController::class, 'setRegistrarCategoria']);
    Route::post('/configuracion/categoria/setEditarCategoria', [CategoriaController::class, 'setEditarCategoria']);

    Route::get('/configuracion/producto/getListarProductos', [ProductoController::class, 'getListarProductos']);
    Route::post('/configuracion/producto/setRegistrarProducto', [ProductoController::class, 'setRegistrarProducto']);
    Route::post('/configuracion/producto/setEditarProducto', [ProductoController::class, 'setEditarProducto']);
    

    Route::get('/configuracion/producto/getListarCatalogoProductos', [ProductoController::class, 'getListarCatalogoProductos']);
    Route::post('/configuracion/producto/setRegistrarCatalogoProducto', [ProductoController::class, 'setRegistrarCatalogoProducto']);
    Route::get('/configuracion/colorproductos/updatesTocktotal', [ProductoController::class, 'updatesTocktotal']);


    Route::get('/configuracion/colorproductos/getListarColores', [ColorproductosController::class, 'getListarColores']);

});




Route::get('/{optional?}', function () {
    return view('app');
})->name('basepath')
->where('optional','.*');

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
