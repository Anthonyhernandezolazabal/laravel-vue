<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function getListaUsuarios(Request $request){
        if (!$request->ajax()) return redirect("/");

        $cNombre    =   $request->cNombre;
        $cUsuario   =   $request->cUsuario;
        $cCorreo    =   $request->cCorreo;
        $cEstado    =   $request->cEstado;

        $cNombre    =   ($cNombre == Null) ? ($cNombre = "") : $cNombre; //Si es null lo setea vacío, de lo contrario lo mantiene con el valor que se envió
        $cUsuario   =   ($cUsuario == Null) ? ($cUsuario = "") : $cUsuario;
        $cCorreo    =   ($cCorreo == Null) ? ($cCorreo = "") : $cCorreo;
        $cEstado    =   ($cEstado == Null) ? ($cEstado = "") : $cEstado;
        //Procedimiento almacenado
        $rpta       =   DB::select("call sp_Usuario_getListUsuarios(?, ?, ?, ?)",
                                                                [
                                                                    $cNombre,
                                                                    $cUsuario,
                                                                    $cCorreo,
                                                                    $cEstado
                                                                ]);
        return $rpta;
    }
}
