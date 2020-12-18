<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\MaterialesEmpaques;

class MaterialesEmpaquesController extends Controller{
    // gets
    public function __construct()
    {
        //$this->middleware('auth:api');
    }

    public function index(){
        $resquest = MaterialesEmpaques::all();
        return response()->json($resquest);
    }
    public function show($id){
        $resquest= MaterialesEmpaques::findOrFail($id);
        return response()->json($resquest);
    }
    public function filtro(Request $request){
        $nombre =$request->nombre;
        $res = MaterialesEmpaques::name($nombre)->get();
        return response()->json($res);
       
    }
    public function show2($id){
        $resquest = MaterialesEmpaques::where('materiales_empaques.id',$id)->first();
        if($resquest == null){
            return response()->json($resquest);
        }
        return response()->json($resquest);
    }
    //post
    public function create(Request $request){
        error_log('Datos Enviados');
        error_log($request);
        $res = new MaterialesEmpaques();
        $res->nombre = $request->nombre;
        $res->stock = $request->stock;
        $res->descripcion = $request->descripcion;
        $res->peso_neto  = $request->peso_neto;
        $res->peso_bruto = $request->peso_bruto;
        $res->medidas  = $request->medidas;
        $res->imagen_material_empaques = $request->imagen_material_empaques;
        if($request->imagen_material_empaques == null){
            $res->imagen_material_empaques = " ";
        }
        $res->codigo_materiales_empaques  = $request->codigo_materiales_empaques;
        $res->save();
        error_log('Datos creados');
        error_log($res);
        return response()->json($res);
    }
    //put
    public function update($id,Request $request){
        $res = MaterialesEmpaques::findOrFail($id);
        $res->nombre = $request->nombre;
        $res->stock = $request->stock;
        $res->descripcion = $request->descripcion;
        $res->peso_neto  = $request->peso_neto;
        $res->peso_bruto = $request->peso_bruto;
        $res->medidas  = $request->medidas;
        $res->imagen_material_empaques = $request->imagen_material_empaques;
        if($request->imagen_material_empaques == null){
            $res->imagen_material_empaques = " ";
        }
        $res->codigo_materiales_empaques  = $request->codigo_materiales_empaques;
        $res->save();
        return response()->json($res);
    }
    //delete
    public function destroy($id){
        MaterialesEmpaques::findOrFail($id)->delete();
    }
}