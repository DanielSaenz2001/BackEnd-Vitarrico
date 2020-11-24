<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use Illuminate\Http\Request;

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
        $res->save();
        return response()->json($res);
    }
    //put
    public function updateProducto($id,Request $request){
        $res = Carrito::findOrFail($id);
        $res->cantidad_producto = $request->cantidad_producto;
        $res->cantidad_empaque = $request->cantidad_empaque;
        $res->save();
        return response()->json($res);
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
        Carrito::findOrFail($id)->delete();
    }
}
