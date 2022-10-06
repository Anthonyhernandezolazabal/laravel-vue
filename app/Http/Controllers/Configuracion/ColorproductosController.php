<?php

namespace App\Http\Controllers\Configuracion;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ColorproductosController extends Controller
{
    public function getListarColores(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $nIdColor   =   $request->nIdColor;
        $cNombre        =   $request->cNombre;
        $cPaleta        =   $request->cPaleta;

        $nIdColor   =   ($nIdColor   ==  NULL) ? ($nIdColor   =   0) :   $nIdColor;
        $cNombre        =   ($cNombre   ==  NULL) ? ($cNombre   =   '') :   $cNombre;
        $cPaleta        =   ($cPaleta   ==  NULL) ? ($cPaleta   =   '') :   $cPaleta;

        $rpta       =   DB::select('call sp_Categoria_getListarColores (?, ?, ?)',
                                                                [
                                                                    $nIdColor,
                                                                    $cNombre,
                                                                    $cPaleta
                                                                ]);
        return $rpta;
    }
}
