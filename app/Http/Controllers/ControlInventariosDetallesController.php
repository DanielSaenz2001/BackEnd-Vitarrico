<?php

namespace App\Http\Controllers;

use App\Models\ControlInventariosDetalles;
use Illuminate\Http\Request;

class ControlInventariosDetallesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    
    public function index(){
        $resquest = ControlInventariosDetalles::all();
        return response()->json($resquest);
    }
    public function show($id){
        $resquest = ControlInventariosDetalles::where('control_inventarios_detalles.control_inventarios_id','=',$id)->first();

        if($resquest !== null){
            if($resquest->prima_id !== null){
                $res= ControlInventariosDetalles::join('materias_primas','control_inventarios_detalles.prima_id','=','materias_primas.id')
                ->select('materias_primas.nombre as producto_nombre','materias_primas.stock as producto_cantidad'
                ,'control_inventarios_detalles.id','control_inventarios_detalles.estado','materias_primas.unidad'
                ,'control_inventarios_detalles.observacion','materias_primas.imagen_materias_primas as producto_imagen'
                ,'materias_primas.descripcion')
                ->where('control_inventarios_detalles.control_inventarios_id','=',$id)
                ->get();
                return response()->json($res,200);
            }
            if($resquest->empaque_id !== null){
                $res= ControlInventariosDetalles::join('materiales_empaques','control_inventarios_detalles.empaque_id','=','materiales_empaques.id')
                ->select('materiales_empaques.nombre as producto_nombre','materiales_empaques.stock as producto_cantidad'
                ,'control_inventarios_detalles.id','control_inventarios_detalles.estado','materiales_empaques.medidas as unidad'
                ,'control_inventarios_detalles.observacion','materiales_empaques.imagen_material_empaques as producto_imagen'
                ,'materiales_empaques.descripcion')
                ->where('control_inventarios_detalles.control_inventarios_id','=',$id)
                ->get();
                return response()->json($res,201);
            }
            if($resquest->producto_id !== null){
                $res= ControlInventariosDetalles::join('productos','control_inventarios_detalles.producto_id','=','productos.id')
                ->select('productos.nombre as producto_nombre','productos.stock as producto_cantidad'
                ,'control_inventarios_detalles.id','control_inventarios_detalles.estado','productos.unidad'
                ,'control_inventarios_detalles.observacion','productos.imagen_producto as producto_imagen'
                ,'productos.descripcion')
                ->where('control_inventarios_detalles.control_inventarios_id','=',$id)
                ->get();
                return response()->json($res,202);
            }
        }
        return response()->json($resquest);
    }
    public function update($id,Request $request){
        $res = ControlInventariosDetalles::findOrFail($id);
        $res->observacion=$request->observacion;
        $res->estado="revisado";
        $res->save();
        return response()->json($res);
    }
}
