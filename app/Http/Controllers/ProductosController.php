<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Productos;

class ProductosController extends Controller{
    // gets
    public function index(){
        $resquest = Productos::all();
        return response()->json($resquest);
    }
    public function show($id){
        $resquest= Productos::findOrFail($id);
        return response()->json($resquest);
    }
    public function filtro(Request $request){
        $nombre =$request->nombre;
        $res = Productos::name($nombre)->get();
        return response()->json($res);
       
    }
    public function show2($id){
        $resquest = Productos::where('productos.id',$id)->get();
        return response()->json($resquest);
    }
    //post
    public function create(Request $request){
        error_log('Datos Enviados');
        error_log($request);
        $res = new Productos();
        $res->nombre = $request->nombre;
        $res->stock = $request->stock;
        $res->descripcion = $request->descripcion;
        $res->precio_total  = $request->precio_total;
        $res->codigo_producto = $request->codigo_producto;
        $res->imagen_producto  = $request->imagen_producto;
        if($request->imagen_producto == null){
            $res->imagen_producto = " ";
        }
        $res->save();
        error_log('Datos creados');
        error_log($res);
        return response()->json($res);
    }
    //put
    public function update($id,Request $request){
        error_log('Id Enviada');
        error_log($id);
        error_log('Datos Enviados');
        error_log($request);
        $res = Productos::findOrFail($id);
        $res->nombre = $request->nombre;
        $res->stock = $request->stock;
        $res->descripcion = $request->descripcion;
        $res->precio_total  = $request->precio_total;
        $res->codigo_producto = $request->codigo_producto;
        $res->imagen_producto  = $request->imagen_producto;
        if($request->imagen_producto == null){
            $res->imagen_producto = " ";
        }
        $res->save();
        error_log('Datos creados');
        error_log($res);
        return response()->json($res);
    }
    //delete
    public function destroy($id){
        $res= Productos::findOrFail($id);
        $res->delete();
        return response()->json($res);
    }
}