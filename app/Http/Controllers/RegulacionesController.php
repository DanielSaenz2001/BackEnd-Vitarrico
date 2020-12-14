<?php

namespace App\Http\Controllers;

use App\Models\Regulaciones;
use App\Models\Productos;
use App\Models\MaterialesEmpaques;
use App\Models\MateriasPrimas;
use Illuminate\Http\Request;

class RegulacionesController extends Controller
{
    public function index(){
        $res = Regulaciones::join('users','regulaciones.responsable','=','users.id')
        ->join('productos','regulaciones.producto_id','=','productos.id')
        ->select('regulaciones.id','regulaciones.cantidad','regulaciones.motivo','regulaciones.tipo','regulaciones.fecha',
        'regulaciones.actividad','productos.nombre as producto_nombre','productos.imagen_producto as imagen_producto'
        ,'users.name as responsable')
        ->get();
        error_log("asdasd");
        return response()->json($res);
    }
    public function index2(){
        $res = Regulaciones::join('users','regulaciones.responsable','=','users.id')
        ->join('materias_primas','regulaciones.prima_id','=','materias_primas.id')
        ->select('regulaciones.id','regulaciones.cantidad','regulaciones.motivo','regulaciones.tipo',
        'regulaciones.actividad','users.name as responsable','regulaciones.fecha'
        ,'materias_primas.nombre as prima_nombre','materias_primas.imagen_materias_primas as imagen_producto'
        )
        ->get();
        return response()->json($res);
    }
    public function index3(){
        $res = Regulaciones::join('users','regulaciones.responsable','=','users.id')
        ->join('materiales_empaques','regulaciones.empaque_id','=','materiales_empaques.id')
        ->select('regulaciones.id','regulaciones.cantidad','regulaciones.motivo','regulaciones.tipo',
        'regulaciones.actividad','regulaciones.fecha','users.name as responsable'
        ,'materiales_empaques.nombre as material_empaque','materiales_empaques.imagen_material_empaques as imagen_producto')
        ->get();
        return response()->json($res);
    }
    public function show($id){
        $resquest= Regulaciones::findOrFail($id);
        if($resquest !== null){
            if($resquest->tipo == "Prima"){
                $res = Regulaciones::join('users','regulaciones.responsable','=','users.id')
                ->join('materias_primas','regulaciones.prima_id','=','materias_primas.id')
                ->where('regulaciones.id','=',$id)
                ->select('regulaciones.id','regulaciones.cantidad','regulaciones.motivo','regulaciones.tipo',
                'regulaciones.actividad','users.name as responsable','regulaciones.fecha'
                ,'materias_primas.nombre as producto_nombre','materias_primas.imagen_materias_primas as imagen_producto'
                )
                ->first();
                return response()->json($res);
            }
            if($resquest->tipo == "Empaque"){
                $res = Regulaciones::join('users','regulaciones.responsable','=','users.id')
                ->join('materiales_empaques','regulaciones.empaque_id','=','materiales_empaques.id')
                ->where('regulaciones.id','=',$id)
                ->select('regulaciones.id','regulaciones.cantidad','regulaciones.motivo','regulaciones.tipo',
                'regulaciones.actividad','regulaciones.fecha','users.name as responsable'
                ,'materiales_empaques.nombre as producto_nombre','materiales_empaques.imagen_material_empaques as imagen_producto')
                ->first();
                return response()->json($res);
            }
            if($resquest->tipo == "Producto"){
                $res = Regulaciones::join('users','regulaciones.responsable','=','users.id')
                ->join('productos','regulaciones.producto_id','=','productos.id')
                ->where('regulaciones.id','=',$id)
                ->select('regulaciones.id','regulaciones.cantidad','regulaciones.motivo','regulaciones.tipo','regulaciones.fecha',
                'regulaciones.actividad','productos.nombre as producto_nombre','productos.imagen_producto as imagen_producto'
                ,'users.name as responsable')
                ->first();
                return response()->json($res);
            }
        }
        return response()->json($resquest);
        
    }
    public function create(Request $request){
        $res = new Regulaciones();
        $res->cantidad = $request->cantidad;
        $res->motivo = $request->motivo;
        $res->actividad  = $request->actividad;
        $res->fecha  = $request->fecha;
        $res->responsable  = 1;

        $res->producto_id = null;
        $res->empaque_id = null;
        $res->prima_id  =null;
        if($request->producto_id !==0){
            $res->producto_id = $request->producto_id;
            $res->tipo  = "Producto";
            $data = Productos::findOrFail($res->producto_id);
            if($res->actividad == "Disminuir"){
                $data->stock=$data->stock - $res->cantidad;
                $data->save();
            }
            if($res->actividad == "Aumentar"){
                $data->stock=$data->stock + $res->cantidad;
                $data->save();
            }
        }
        if($request->empaque_id !==0){
            $res->empaque_id = $request->empaque_id;
            $res->tipo  = "Empaque";
            $data = MaterialesEmpaques::findOrFail($res->empaque_id);
            if($res->actividad == "Disminuir"){
                $data->stock=$data->stock - $res->cantidad;
                $data->save();
            }
            if($res->actividad == "Aumentar"){
                $data->stock=$data->stock + $res->cantidad;
                $data->save();
            }
        }
        if($request->prima_id !==0){
            $res->prima_id = $request->prima_id;
            $res->tipo  = "Prima";
            $data = MateriasPrimas::findOrFail($res->prima_id);
            if($res->actividad == "Disminuir"){
                $data->stock=$data->stock - $res->cantidad;
                $data->save();
            }
            if($res->actividad == "Aumentar"){
                $data->stock=$data->stock + $res->cantidad;
                $data->save();
            }
        }
        $res->save();
    }
}
