<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
        $rpta       =   DB::select("call sp_Usuario_getListarUsuarios(?, ?, ?, ?)",
                                                                [
                                                                    $cNombre,
                                                                    $cUsuario,
                                                                    $cCorreo,
                                                                    $cEstado
                                                                ]);
        return $rpta;
    }
    public function setRegistrarUsuario(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $cPrimerNombre  =   $request->cPrimerNombre;
        $cSegundoNombre =   $request->cSegundoNombre;
        $cApellido      =   $request->cApellido;
        $cUsuario       =   $request->cUsuario;
        $cCorreo        =   $request->cCorreo;
        $cContrasena    =   Hash::make($request->cContrasena);
        $oFotografia    =   $request->oFotografia;

        $cPrimerNombre  =   ($cPrimerNombre   ==  NULL) ? ($cPrimerNombre   =   '') :   $cPrimerNombre;
        $cSegundoNombre =   ($cSegundoNombre   ==  NULL) ? ($cSegundoNombre   =   '') :   $cSegundoNombre;
        $cApellido      =   ($cApellido   ==  NULL) ? ($cApellido   =   '') :   $cApellido;
        $cUsuario       =   ($cUsuario   ==  NULL) ? ($cUsuario   =   '') :   $cUsuario;
        $cCorreo        =   ($cCorreo   ==  NULL) ? ($cCorreo   =   '') :   $cCorreo;
        $cContrasena    =   ($cContrasena   ==  NULL) ? ($cContrasena   =   '') :   $cContrasena;
        $oFotografia    =   ($oFotografia   ==  NULL) ? ($oFotografia   =   NULL) :   $oFotografia;

        $rpta   =   DB::select('call sp_Usuario_setRegistrarUsuario (?, ?, ?, ?, ?, ?, ?)',
                                                                [
                                                                    $cPrimerNombre,
                                                                    $cSegundoNombre,
                                                                    $cApellido,
                                                                    $cUsuario,
                                                                    $cCorreo,
                                                                    $cContrasena,
                                                                    $oFotografia
                                                                ]);

        return $rpta;
    }
}
