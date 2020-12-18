<?php

namespace App\Http\Controllers;

use App\Models\inMatePrimasDetalles;
use Illuminate\Http\Request;

class InMatePrimasDetallesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(){
        $resquest = inMatePrimasDetalles::all();
        return response()->json($resquest);
    }
    public function show($id)
    {
        $resquest= inMatePrimasDetalles::join('materias_primas','in_mate_primas_detalles.prima_id','=','materias_primas.id')
        ->select('materias_primas.nombre as materia_prima_nombre'
        ,'in_mate_primas_detalles.cantidad_prima as cantidad_prima'
        ,'in_mate_primas_detalles.integridad as integridad'
        ,'in_mate_primas_detalles.plagas as plagas'
        ,'in_mate_primas_detalles.materias_extranas as materias_extranas'
        ,'materias_primas.imagen_materias_primas as materia_prima_imagen')
        ->where('in_mate_primas_detalles.in_materias_prima_id','=',$id)
        ->get();
        return response()->json($resquest);
    }
}
