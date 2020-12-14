<?php

namespace App\Http\Controllers;

use App\Models\ProductosElaboraciones;
use Illuminate\Http\Request;
use App\Models\ProductosElaboracionesDetalles;
use App\Models\Productos;
use App\Models\Carrito;

class ProductosElaboracionesController extends Controller
{
    public function index(){
        $res = ProductosElaboraciones::join('users','productos_elaboraciones.responsable','=','users.id')
        ->join('productos','productos.id','=','productos_elaboraciones.producto_id')
        ->select('productos_elaboraciones.id','productos_elaboraciones.fecha','productos_elaboraciones.cantidad_producto'
        ,'productos.nombre as nombre_producto','users.name as responsable_nombre',
        'productos.imagen_producto as imagen_producto')->get();
        return response()->json($res);
    }
    public function show($id){
        $res= ProductosElaboraciones::join('users','productos_elaboraciones.responsable','=','users.id')
        ->join('productos','productos.id','=','productos_elaboraciones.producto_id')
        ->where('productos_elaboraciones.id','=',$id)
        ->select('productos_elaboraciones.id','productos_elaboraciones.fecha','productos_elaboraciones.cantidad_producto'
        ,'users.name as responsable_nombre','productos.nombre as nombre_producto','productos.imagen_producto as imagen_producto','productos_elaboraciones.responsable')->first();
        return response()->json($res);
    }
    public function create(Request $request){
       
       
        $res = new ProductosElaboraciones();
        $res->fecha = $request->fecha;
        $res->cantidad_producto = $request->cantidad_producto;
        $res->producto_id  = $request->producto_id;
        $res->responsable  = 1;
        
        //eeror $res->cantidad_producto 
        error_log($res->cantidad_producto);

        if($res->cantidad_producto  < 20){
            return response()->json(array(
                'code'      =>  404,
                'message'   =>  "La cantidad a elaborar debe ser mayor a 20"
            ), 404);
        }
        
        //$user = $request->user_id;
        $tipo = "elaboracion";
        $user = 1;
        $carrito = Carrito::tipo($tipo)->user($user)
        ->join('materias_primas','carritos.materias_primas_id','=','materias_primas.id')
        ->select('carritos.id','carritos.cantidad_materias as cantidad_materias' 
        ,'carritos.materias_primas_id  as materias_primas_id')
        ->get();
        if (count($carrito) < 1) {
            return response()->json(array(
                'code'      =>  400,
                'message'   =>  "No se puedo crear ya que no cuenta con ningun producto"
            ), 400);
        }
        $res->save();
        
        foreach ($carrito as $data){
            $res2 = new ProductosElaboracionesDetalles();
            $res2->cantidad_materias = $data->cantidad_materias;
            $res2->materias_id  = $data->materias_primas_id;
            $res2->prod_elabo_id   = $res->id;
            $res2->save();
        }
        Carrito::tipo($tipo)->user($user)->delete();
        $productos = Productos::findOrFail($res->producto_id);
        $productos->stock = $productos->stock + $res->cantidad_producto;
        $productos->save();
        return response()->json($res);
    }
}
