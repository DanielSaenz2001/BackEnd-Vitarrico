<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Carrito;
use App\Models\ProductosDespachos;
use App\Models\ProductosDespachosDetalles;

class ProductosDespachosController extends Controller{
    // gets
    public function index(){
        $res = ProductosDespachos::all();
        return response()->json($res);
    }
    public function show($id){
        $res= ProductosDespachos::findOrFail($id);
        return response()->json($res);
    }
    //post
    public function create(Request $request){
       
        $res = new ProductosDespachos();
        $res->vehiculo = $request->vehiculo;
        $res->nombreConductor = $request->nombreConductor;
        $res->fecha = $request->fecha;
        $res->ciudadDestino = $request->ciudadDestino;
        $res->responsable  = 1;
        $res->save();

        
        
        //$user = $request->user_id;
        $tipo = "despachos";
        $user = 1;
        $carrito = Carrito::tipo($tipo)->user($user)
        ->join('productos','carritos.producto_id','=','productos.id')
        ->join('materiales_empaques','carritos.empaque_id','=','materiales_empaques.id')
        ->select('carritos.id','productos.nombre as producto_nombre','productos.stock as productos_stock',
        'materiales_empaques.nombre as empaque_nombre','carritos.cantidad_producto as cantidad_producto' ,'carritos.cantidad_empaque as cantidad_empaque' 
         , 'materiales_empaques.stock as empaques_stock'
        ,'productos.imagen_producto as producto_imagen','materiales_empaques.imagen_material_empaques as empaque_imagen',
        'materiales_empaques.id as empaque_id', 'carritos.producto_id','carritos.empaque_id','carritos.user_id')
        ->get();
        foreach ($carrito as $data ){
            $res2 = new ProductosDespachosDetalles();
            $res2->cantidad_producto = $data->cantidad_producto;
            $res2->cantidad_empaque = $data->cantidad_empaque;
            $res2->material_empaque_id  = $data->empaque_id;
            $res2->producto_id = $data->producto_id;
            $res2->productos_despachos_id = $res->id;
            $res2->save();
            error_log($res2);
        }
        Carrito::tipo($tipo)->user($user)->delete();

        return response()->json($res);
    }
}