<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\ProductosDespachosDetalles;

class ProductosDespachosDetallesController extends Controller{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(){
        $resquest = ProductosDespachosDetalles::all();
        return response()->json($resquest);
    }
    public function show($id){
        $resquest= ProductosDespachosDetalles::join('productos','productos_despachos_detalles.producto_id','=','productos.id')
        ->join('materiales_empaques','productos_despachos_detalles.material_empaque_id','=','materiales_empaques.id')
        ->select('productos.nombre as producto_nombre','materiales_empaques.nombre as empaque_nombre',
        'productos_despachos_detalles.cantidad_producto as cantidad_producto' ,'productos_despachos_detalles.cantidad_empaque as cantidad_empaque' 
        ,'productos.imagen_producto as producto_imagen','materiales_empaques.imagen_material_empaques as empaque_imagen')
        ->where('productos_despachos_detalles.productos_despachos_id','=',$id)
        ->get();
        return response()->json($resquest);
    }

    public function create(Request $request){

        $res = new ProductosDespachosDetalles();
        $res->cantidad_producto = $request->cantidad_producto;
        $res->cantidad_empaque = $request->cantidad_empaque;
        $res->material_empaque_id  = $request->material_empaque_id;
        $res->producto_id = $request->producto_id;
        $res->productos_despachos_id = $request->productos_despachos_id;
        $res->save();
        return response()->json($res);
    }
}