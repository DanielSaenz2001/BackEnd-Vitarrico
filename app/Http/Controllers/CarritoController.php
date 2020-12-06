<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use Illuminate\Http\Request;
use App\Models\Productos;

class CarritoController extends Controller
{
    
    public function showListDespachos(Request $request){
        $tipo = $request->tipo;
        //$user = $request->user_id;
        $tipo = "despachos";
        $user = 1;
        $carrito = Carrito::tipo($tipo)->user($user)->get();

        $resquest = Carrito::join('productos','carritos.producto_id','=','productos.id')
        ->join('materiales_empaques','carritos.empaque_id','=','materiales_empaques.id')
        ->select('carritos.id','productos.nombre as producto_nombre','productos.stock as productos_stock',
        'materiales_empaques.nombre as empaque_nombre','carritos.cantidad_producto as cantidad_producto' ,'carritos.cantidad_empaque as cantidad_empaque' 
         , 'materiales_empaques.stock as empaques_stock'
        ,'productos.imagen_producto as producto_imagen','materiales_empaques.imagen_material_empaques as empaque_imagen',
        'materiales_empaques.id as empaque_id', 'carritos.producto_id','carritos.empaque_id','carritos.user_id')
        ->get();
        return response()->json($resquest);
    }

    public function showListProduccion(Request $request){
        $tipo = $request->tipo;
        //$user = $request->user_id;
        $tipo = "produccion";
        $user = 1;
        $resquest = Carrito::tipo($tipo)->user($user)->get();
        return response()->json($resquest);
    }
    
    public function create(Request $request){
        $res = new Carrito();
        $res->producto_id = $request->producto_id;
        $res->cantidad_producto = 1;
        $res->descripcion = $request->descripcion;
        $res->lote  = $request->lote;
        $res->tipo = $request->tipo;
        $res->cantidad_empaque = 1;
        $res->user_id  = 1;
        $res->empaque_id  = 1;
        $producto = Productos::findOrFail($request->producto_id);
        if($producto->stock -1  < 0){
            return response()->json(array(
                'code'      =>  406,
                'message'   =>  "No hay stock disponible en el almacen, comuniquele a su jefe lo mas antes posible."
            ), 406);
        }
        $producto->stock = $producto->stock - 1;
        $producto->save();
        $res->save();
        return response()->json($res);
    }
    //put
    public function updateProducto($id,Request $request){
        $carrito = Carrito::findOrFail($id);
        if($request->cantidad_producto < $carrito->cantidad_producto){
            $resultado= $carrito->cantidad_producto -$request->cantidad_producto;
            $producto = Productos::findOrFail($carrito->producto_id);
            $producto->stock = $producto->stock + $resultado;
            $producto->save();
        }
        if($request->cantidad_producto == 0){
            return response()->json(array(
                'code'      =>  400,
                'message'   =>  "La cantidad del producto no puede ser 0, le aconsejamos que lo elimine."
            ), 400);
        }
        if($request->cantidad_producto > $carrito->cantidad_producto){
            $resultado= $request->cantidad_producto - $carrito->cantidad_producto;
            $producto = Productos::findOrFail($carrito->producto_id);
            $producto->stock = $producto->stock - $resultado;
            if($producto->stock  < 0){
                return response()->json(array(
                    'code'      =>  406,
                    'message'   =>  "No hay stock disponible en el almacen, comuniquele a su jefe lo mas antes posible."
                ), 406);
            }
            $producto->save();
        }
        $carrito->cantidad_producto = $request->cantidad_producto;
        $carrito->cantidad_empaque = $request->cantidad_empaque;
        $carrito->save();
        return response()->json($carrito);
    }
    public function updateEmpaque($id,Request $request){
        $res = Carrito::findOrFail($id);
        $res->empaque_id = $request->empaque_id;
        $res->cantidad_empaque = 1;
        $res->save();
        return response()->json($res);
    }
    //delete
    public function destroy($id){
        $carrito=Carrito::findOrFail($id);

        $carrito->delete();

        $producto = Productos::findOrFail( $carrito->producto_id);
        $producto->stock = $producto->stock + $carrito->cantidad_producto;
        $producto->save();
        
    }
}
