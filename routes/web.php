<?php
use Illuminate\Support\Facades\Route;
Route::get('/{optionsl?}', function () {
    return view('app');
})->name('basepath');
Route::get("/administracion/usuario/getListarUsuarios", "Administracion\UsersController@getListarUsuarios");
