<?php

namespace App\Http\Controllers\Administracion;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function getListaUsuarios(Request $request)
    {
        if (!$request->ajax()) return redirect("/");

        $nIdUsuario     =   $request->nIdUsuario;
        $cNombre        =   $request->cNombre;
        $cUsuario       =   $request->cUsuario;
        $cCorreo        =   $request->cCorreo;
        $cEstado        =   $request->cEstado;

        $nIdUsuario         =   ($nIdUsuario ==  NULL)   ? ($nIdUsuario  =   0) :   $nIdUsuario;
        $cNombre            =   ($cNombre == Null) ? ($cNombre = "") : $cNombre; //Si es null lo setea vacío, de lo contrario lo mantiene con el valor que se envió
        $cUsuario           =   ($cUsuario == Null) ? ($cUsuario = "") : $cUsuario;
        $cCorreo            =   ($cCorreo == Null) ? ($cCorreo = "") : $cCorreo;
        $cEstado            =   ($cEstado == Null) ? ($cEstado = "") : $cEstado;
        //Procedimiento almacenado
        $rpta       =   DB::select("call sp_Usuario_getListarUsuarios(?, ?, ?, ?, ?)",
                                                                [
                                                                    $nIdUsuario,
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

        $nIdAuthUser=   Auth::id();
        $cPrimerNombre  =   ($cPrimerNombre   ==  NULL) ? ($cPrimerNombre   =   '') :   $cPrimerNombre;
        $cSegundoNombre =   ($cSegundoNombre   ==  NULL) ? ($cSegundoNombre   =   '') :   $cSegundoNombre;
        $cApellido      =   ($cApellido   ==  NULL) ? ($cApellido   =   '') :   $cApellido;
        $cUsuario       =   ($cUsuario   ==  NULL) ? ($cUsuario   =   '') :   $cUsuario;
        $cCorreo        =   ($cCorreo   ==  NULL) ? ($cCorreo   =   '') :   $cCorreo;
        $cContrasena    =   ($cContrasena   ==  NULL) ? ($cContrasena   =   '') :   $cContrasena;
        $oFotografia    =   ($oFotografia   ==  NULL) ? ($oFotografia   =   NULL) :   $oFotografia;

        $rpta   =   DB::select('call sp_Usuario_setRegistrarUsuario (?, ?, ?, ?, ?, ?, ?, ?)',
                                                                [
                                                                    $cPrimerNombre,
                                                                    $cSegundoNombre,
                                                                    $cApellido,
                                                                    $cUsuario,
                                                                    $cCorreo,
                                                                    $cContrasena,
                                                                    $oFotografia,
                                                                    $nIdAuthUser
                                                                ]);

        return $rpta[0]->nIdUsuario;
    }
    public function setEditarUsuario(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $nIdUsuario     =   $request->nIdUsuario;
        $cPrimerNombre  =   $request->cPrimerNombre;
        $cSegundoNombre =   $request->cSegundoNombre;
        $cApellido      =   $request->cApellido;
        $cUsuario       =   $request->cUsuario;
        $cCorreo        =   $request->cCorreo;
        $cContrasena    =   $request->cContrasena;
        if ($cContrasena != NULL) {
            $cContrasena    =   Hash::make($cContrasena);
        }

        $oFotografia    =   $request->oFotografia;
        $nIdAuthUser    =   Auth::id();

        $nIdUsuario     =   ($nIdUsuario   ==  NULL) ? ($nIdUsuario   =   '') :   $nIdUsuario;
        $cPrimerNombre  =   ($cPrimerNombre   ==  NULL) ? ($cPrimerNombre   =   '') :   $cPrimerNombre;
        $cSegundoNombre =   ($cSegundoNombre   ==  NULL) ? ($cSegundoNombre   =   '') :   $cSegundoNombre;
        $cApellido      =   ($cApellido   ==  NULL) ? ($cApellido   =   '') :   $cApellido;
        $cUsuario       =   ($cUsuario   ==  NULL) ? ($cUsuario   =   '') :   $cUsuario;
        $cCorreo        =   ($cCorreo   ==  NULL) ? ($cCorreo   =   '') :   $cCorreo;
        $cContrasena    =   ($cContrasena   ==  NULL) ? ($cContrasena   =   '') :   $cContrasena;
        // $oFotografia    =   ($oFotografia   ==  0) ? ($oFotografia   =   NULL) :   $oFotografia;



        DB::select('call sp_Usuario_setEditarUsuario (?, ?, ?, ?, ?, ?, ?, ?, ?)',
                                                                [
                                                                    $nIdUsuario,
                                                                    $cPrimerNombre,
                                                                    $cSegundoNombre,
                                                                    $cApellido,
                                                                    $cUsuario,
                                                                    $cCorreo,
                                                                    $cContrasena,
                                                                    $oFotografia,
                                                                    $nIdAuthUser
                                                                ]);

    }

    public function setCambiarEstadoUsuario(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $nIdUsuario     =   $request->nIdUsuario;
        $cEstado     =   $request->cEstado;
        $nIdAuthUser =   Auth::id();

        $nIdUsuario  =   ($nIdUsuario   ==  NULL) ? ($nIdUsuario   =   0) :   $nIdUsuario;
        $cEstado     =   ($cEstado   ==  NULL) ? ($cEstado   =   0) :   $cEstado;

        DB::select('call sp_Usuario_setCambiarEstadoUsuario (?, ?, ?)',
                                                                [
                                                                    $nIdUsuario,
                                                                    $cEstado,
                                                                    $nIdAuthUser
                                                                ]);

    }

    public function setEditarRolByUsuario(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $nIdUsuario  =   $request->nIdUsuario;
        $nIdRol      =   $request->nIdRol;

        $nIdUsuario =   ($nIdUsuario   ==  NULL) ? ($nIdUsuario   =   '') :   $nIdUsuario;
        $nIdRol     =   ($nIdRol   ==  NULL) ? ($nIdRol   =   '') :   $nIdRol;

        DB::select('call sp_Usuario_setEditarRolByUsuario (?, ?)',
                                                        [
                                                            $nIdUsuario,
                                                            $nIdRol
                                                        ]);

        return $nIdRol;

    }

    public function getRolByUsuario(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $nIdUsuario  =   $request->nIdUsuario;

        $nIdUsuario =   ($nIdUsuario   ==  NULL) ? ($nIdUsuario   =   '') :   $nIdUsuario;

        $rpta   =   DB::select('call sp_Usuario_getRolByUsuario (?)',
                                                [
                                                    $nIdUsuario
                                                ]);

        return $rpta;
    }

    public function getListarPermisosByRolAsignado(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $nIdUsuario  =   $request->nIdUsuario;

        $nIdUsuario =   ($nIdUsuario   ==  NULL) ? ($nIdUsuario   =   '') :   $nIdUsuario;

        $rpta   =   DB::select('call sp_Usuario_getListarPermisosByRolAsignado (?)',
                                                [
                                                    $nIdUsuario
                                                ]);

        return $rpta;
    }

    public function getListarPermisosByUsuario(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $nIdUsuario  =   $request->nIdUsuario;

        $nIdUsuario =   ($nIdUsuario   ==  NULL) ? ($nIdUsuario   =   0) :   $nIdUsuario;

        $rpta   =   DB::select('call sp_Usuario_getListarPermisosByUsuario (?)',
                                                [
                                                    $nIdUsuario
                                                ]);

        return $rpta;
    }
    public function setRegistrarPermisosByUsuario(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $nIdUsuario  =   $request->nIdUsuario;

        $nIdUsuario =   ($nIdUsuario   ==  NULL) ? ($nIdUsuario   =   0) :   $nIdUsuario;

        try {
            // Ira todo el codigo que deseamos realizar
            DB::beginTransaction();

            DB::select('call sp_Usuario_setEliminarPermisosByUsuario (?)',
                                                                    [
                                                                        $nIdUsuario
                                                                    ]);

            $listPermisos       =   $request->listPermisosFilter;
            $listPermisosSize   =   sizeof($listPermisos);
            if ($listPermisosSize > 0) {
                foreach ($listPermisos as $key => $value) {
                    if ($value['checked'] == true) {
                        DB::select('call sp_Usuario_setRegistrarPermisosByUsuario (?, ?)',
                                                                [
                                                                    $nIdUsuario,
                                                                    $value['id']
                                                                ]);
                    }
                }
            }
            DB::commit();
        } catch (Exception $e) {
            // capturara algun error ocurrido en el "try"
            DB::rollBack();
        }
    }

    public function getListarRolPermisosByUsuario(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $nIdUsuario  =   $request->nIdUsuario;
        if (!$nIdUsuario) {
            $nIdUsuario =   Auth::id();
        }

        $nIdUsuario =   ($nIdUsuario   ==  NULL) ? ($nIdUsuario   =   0) :   $nIdUsuario;

        $rpta   =   DB::select('call sp_Usuario_getListarRolPermisosByUsuario (?)',
                                                [
                                                    $nIdUsuario
                                                ]);

        return $rpta;
    }
}
