<?php

namespace App\Http\Controllers;

use App\Models\ProductosElaboracionesDetalles;
use Illuminate\Http\Request;

class ProductosElaboracionesDetallesController extends Controller
{
    public function index(){
        $resquest = ProductosElaboracionesDetalles::all();
        return response()->json($resquest);
    }
    public function show($id){
        $resquest= ProductosElaboracionesDetalles::join('materias_primas','productos_elaboraciones_detalles.materias_id','=','materias_primas.id')
        ->select('materias_primas.nombre as materia_prima_nombre'
        ,'productos_elaboraciones_detalles.cantidad_materias as cantidad_materia'
        ,'materias_primas.imagen_materias_primas as materia_prima_imagen')
        ->where('productos_elaboraciones_detalles.prod_elabo_id','=',$id)
        ->get();
        //$resquest = ProductosElaboracionesDetalles::
        //join('materias_primas','productos_elaboraciones_detalles.materias_id','=','materias_primas.id')->get();
        return response()->json($resquest);
    }
}
