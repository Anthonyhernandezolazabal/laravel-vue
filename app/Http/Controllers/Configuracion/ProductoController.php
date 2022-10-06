<?php

namespace App\Http\Controllers\Configuracion;


use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    public function getListarProductos(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $nIdProducto    =   $request->nIdProducto;
        $cNombre        =   $request->cNombre;
        $cDescripcion   =   $request->cDescripcion;
        $nIdCategoria   =   $request->nIdCategoria;

        $nIdProducto    =   ($nIdProducto   ==  NULL) ? ($nIdProducto   =   0) :   $nIdProducto;
        $cNombre        =   ($cNombre   ==  NULL) ? ($cNombre   =   '') :   $cNombre;
        $cDescripcion   =   ($cDescripcion   ==  NULL) ? ($cDescripcion   =   '') :   $cDescripcion;
        $nIdCategoria   =   ($nIdCategoria   ==  NULL) ? ($nIdCategoria   =   0) :   $nIdCategoria;

        $rpta       =   DB::select('call sp_Producto_getListarProductos (?, ?, ?, ?)',
                                                                [
                                                                    $nIdProducto,
                                                                    $cNombre,
                                                                    $cDescripcion,
                                                                    $nIdCategoria
                                                                ]);
        return $rpta;
    }

    public function setRegistrarProducto(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $cNombre        =   $request->cNombre;
        $cDescripcion   =   $request->cDescripcion;
        $fPrecio        =   $request->fPrecio;
        $nIdCategoria   =   $request->nIdCategoria;
        $nIdAuthUser    =   Auth::id();

        $cNombre        =   ($cNombre   ==  NULL) ? ($cNombre   =   '') :   $cNombre;
        $cDescripcion   =   ($cDescripcion   ==  NULL) ? ($cDescripcion   =   '') :   $cDescripcion;
        $fPrecio        =   ($fPrecio   ==  NULL) ? ($fPrecio   =   0) :   $fPrecio;
        $nIdCategoria   =   ($nIdCategoria   ==  NULL) ? ($nIdCategoria   =   0) :   $nIdCategoria;

        $rpta       =   DB::select('call sp_Producto_setRegistrarProducto (?, ?, ?, ?, ?)',
                                                                [
                                                                    $cNombre,
                                                                    $cDescripcion,
                                                                    $fPrecio,
                                                                    $nIdCategoria,
                                                                    $nIdAuthUser
                                                                ]);
        return $rpta;
    }

    public function setEditarProducto(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $nIdProducto    =   $request->nIdProducto;
        $cNombre        =   $request->cNombre;
        $cDescripcion   =   $request->cDescripcion;
        $fPrecio        =   $request->fPrecio;
        $nIdCategoria   =   $request->nIdCategoria;
        $nIdAuthUser    =   Auth::id();

        $nIdProducto    =   ($nIdProducto   ==  NULL) ? ($nIdProducto   =   0) :   $nIdProducto;
        $cNombre        =   ($cNombre   ==  NULL) ? ($cNombre   =   '') :   $cNombre;
        $cDescripcion   =   ($cDescripcion   ==  NULL) ? ($cDescripcion   =   '') :   $cDescripcion;
        $fPrecio        =   ($fPrecio   ==  NULL) ? ($fPrecio   =   0) :   $fPrecio;
        $nIdCategoria   =   ($nIdCategoria   ==  NULL) ? ($nIdCategoria   =   0) :   $nIdCategoria;

        $rpta       =   DB::select('call sp_Producto_setEditarProducto (?, ?, ?, ?, ?, ?)',
                                                                [
                                                                    $nIdProducto,
                                                                    $cNombre,
                                                                    $cDescripcion,
                                                                    $fPrecio,
                                                                    $nIdCategoria,
                                                                    $nIdAuthUser
                                                                ]);
        return $rpta;
    }

    public function getListarCatalogoProductos(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $nIdProducto   =   $request->nIdProducto;
        $nIdProducto    =   ($nIdProducto   ==  NULL) ? ($nIdProducto   =   0) :   $nIdProducto;

        $rpta       =   DB::select('call sp_Producto_getListarCatalogoProductos (?)',
                                                                [
                                                                    $nIdProducto
                                                                ]);
        return $rpta;
    }

    public function setRegistrarCatalogoProducto(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        if($request->hasFile("oImagen")){
            $file       =   $request->oImagen;
            $bandera    =   Str::random(10); //Generará un string alfanumerico
            $filename = $request->oImagen->getClientOriginalName();
            $fileserver =   $bandera .'_'. $filename."-".$request->nIdProducto;
            $cStock   =   $request->cStock;
            $nIdProducto   =   $request->nIdProducto;
            $cColorPaleta   =   $request->cColorPaleta;

            Storage::putFileAs('public/catalogo', $file, $fileserver);

            $rpta       =   DB::select('call sp_Producto_setRegistrarCatalogoProducto (?, ?, ?, ?, ?)',
                                                                                            [
                                                                                                asset('storage/catalogo/'. $fileserver),
                                                                                                $filename,
                                                                                                $cStock,
                                                                                                $nIdProducto,
                                                                                                $cColorPaleta
                                                                                            ]);

            $nTotalStock =   $rpta[0]->nTotalStock;
            DB::select('call sp_Producto_setModificarStockProducto (?, ?)',
                                                    [
                                                        $nTotalStock,
                                                        $nIdProducto
                                                    ]);


        }
    }

  
}
