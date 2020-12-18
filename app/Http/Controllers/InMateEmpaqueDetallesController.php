<?php

namespace App\Http\Controllers;

use App\Models\inMateEmpaqueDetalles;
use Illuminate\Http\Request;

class InMateEmpaqueDetallesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(){
        $resquest = inMateEmpaqueDetalles::all();
        return response()->json($resquest);
    }
    public function show($id)
    {
        error_log($id);
        $resquest= inMateEmpaqueDetalles::join('materiales_empaques','in_mate_empaque_detalles.empaque_id','=','materiales_empaques.id')
        ->select('materiales_empaques.nombre as material_empaque_nombre'
        ,'in_mate_empaque_detalles.cantidad_empaque as cantidad_empaque'
        ,'in_mate_empaque_detalles.calidad as calidad'
        ,'in_mate_empaque_detalles.laminacion as laminacion'
        ,'in_mate_empaque_detalles.color as color'
        ,'materiales_empaques.imagen_material_empaques as material_empaque_imagen')
        ->where('in_mate_empaque_detalles.in_materiales_empaque_id','=',$id)
        ->get();
        return response()->json($resquest);
    }
}
