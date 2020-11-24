<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\ProductosDespachosDetalles;

class ProductosDespachosDetallesController extends Controller{
    // gets
    public function index(){
        $resquest = ProductosDespachosDetalles::all();
        return response()->json($resquest);
    }
    public function show($id){
        $resquest= ProductosDespachosDetalles::findOrFail($id);
        return response()->json($resquest);
    }
    //post
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