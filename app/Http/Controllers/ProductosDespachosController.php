<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\ProductosDespachos;

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
        $res->Nrelacion  = $request->Nrelacion;
        $res->ciudadDestino = $request->ciudadDestino;
        $res->responsable  = $request->user_id;
        $res->estado  = $request->estado;
        $res->save();
        return response()->json($res);
    }
    //put
    public function update($id,Request $request){
        $res = ProductosDespachos::findOrFail($id);
        $res->vehiculo = $request->vehiculo;
        $res->nombreConductor = $request->nombreConductor;
        $res->fecha = $request->fecha;
        $res->Nrelacion  = $request->Nrelacion;
        $res->ciudadDestino = $request->ciudadDestino;
        $res->user_id  = $request->user_id;
        $res->estado  = $request->estado;
        $res->save();
        return response()->json($res);
    }
    //delete
    public function destroy($id){
        ProductosDespachos::findOrFail($id)->delete();
    }
}