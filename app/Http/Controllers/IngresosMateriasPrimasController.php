<?php

namespace App\Http\Controllers;

use App\Models\IngresosMateriasPrimas;
use Illuminate\Http\Request;

class IngresosMateriasPrimasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(){
        $resquest = IngresosMateriasPrimas::join('users','ingresos_materias_primas.recibe','=','users.id')
        ->join('proveedores','ingresos_materias_primas.proveedor_id','=','proveedores.id')
        ->select('ingresos_materias_primas.id','ingresos_materias_primas.fecha','ingresos_materias_primas.nFactura'
        ,'ingresos_materias_primas.doc_completa','ingresos_materias_primas.observacion',
        'users.name as recibe','proveedores.nombre as proveedor','proveedores.imagen_proveedores as proveedor_imagen')->get();
        return response()->json($resquest);
    }
    public function show($id){
        $resquest= IngresosMateriasPrimas::join('users','ingresos_materias_primas.recibe','=','users.id')
        ->join('proveedores','ingresos_materias_primas.proveedor_id','=','proveedores.id')
        ->where('ingresos_materias_primas.id','=',$id)
        ->select('ingresos_materias_primas.id','ingresos_materias_primas.fecha','ingresos_materias_primas.nFactura'
        ,'ingresos_materias_primas.doc_completa','ingresos_materias_primas.observacion',
        'users.name as recibe','proveedores.nombre as proveedor','proveedores.imagen_proveedores as proveedor_imagen')->first();
        return response()->json($resquest);
    }
    public function show2($id){
        $resquest = IngresosMateriasPrimas::where('ingresos_materias_primas.id',$id)->get();
        return response()->json($resquest);
    }
    //post
    public function create(Request $request){
        $res = new IngresosMateriasPrimas();
        $res->fecha = $request->fecha;
        $res->nFactura = $request->nFactura;
        $res->proveedor_id  = $request->proveedor_id;
       
        $res->observacion  = $request->observacion;
        $res->recibe  = auth()->user()->id;
        $res->save();
        return response()->json($res);
    }
    public function destroy($id){
        IngresosMateriasPrimas::findOrFail($id)->delete();
    }
}
