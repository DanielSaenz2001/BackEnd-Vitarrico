<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\MateriasPrimas;

class MateriasPrimasController extends Controller{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    // gets
    public function index(){
        $resquest = MateriasPrimas::all();
        return response()->json($resquest);
    }
    public function show($id){
        $resquest= MateriasPrimas::findOrFail($id);
        return response()->json($resquest);
    }
    public function filtro(Request $request){
        $nombre =$request->nombre;
        $res = MateriasPrimas::name($nombre)->get();
        return response()->json($res);
       
    }
    public function show2($id){
        $resquest = MateriasPrimas::where('materias_primas.id',$id)->first();
        return response()->json($resquest);
    }
    //post
    public function create(Request $request){
        $res = new MateriasPrimas();
        $res->nombre = $request->nombre;
        $res->stock = $request->stock;
        $res->descripcion = $request->descripcion;
        $res->unidad  = $request->unidad;
        $res->origen = $request->origen;
        $res->imagen_materias_primas  = $request->imagen_materias_primas;
        if($request->imagen_materias_primas == null){
            $res->imagen_materias_primas = " ";
        }
        $res->codigo_materia_prima = $request->codigo_materia_prima;
        $res->save();
        return response()->json($res);
    }
    //put
    public function update($id,Request $request){
        $res = MateriasPrimas::findOrFail($id);
        $res->nombre = $request->nombre;
        $res->stock = $request->stock;
        $res->descripcion = $request->descripcion;
        $res->almacen  = $request->almacen;
        $res->unidad  = $request->unidad;
        $res->origen = $request->origen;
        $res->imagen_materias_primas  = $request->imagen_materias_primas;
        if($request->imagen_materias_primas == null){
            $res->imagen_materias_primas = " ";
        }
        $res->codigo_materia_prima = $request->codigo_materia_prima;
        $res->save();
        return response()->json($res);
    }
    //delete
    public function destroy($id){
        MateriasPrimas::findOrFail($id)->delete();
    }
}