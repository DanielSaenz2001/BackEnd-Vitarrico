<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Proveedores;

class ProveedoresController extends Controller{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    // gets
    public function index(){
        $resquest = Proveedores::all();
        return response()->json($resquest);
    }
    public function show($id){
        $resquest= Proveedores::findOrFail($id);
        return response()->json($resquest);
    }
    public function filtro(Request $request){
        $nombre =$request->ruc;
        $res = Proveedores::name($nombre)->get();
        return response()->json($res);
       
    }
    public function show2($id){
        $resquest = Proveedores::where('proveedores.id',$id)->get();
        return response()->json($resquest);
    }
    //post
    public function create(Request $request){
        $res = new Proveedores();
        $res->nombre = $request->nombre;
        $res->ruc = $request->ruc;
        $res->direccion = $request->direccion;
        $res->tipo  = $request->tipo;
        $res->correo_electronico = $request->correo_electronico;
        $res->responsable  = $request->responsable;
        $res->imagen_proveedores = $request->imagen_proveedores;
        if($request->imagen_proveedores == null){
            $res->imagen_proveedores = " ";
        }
        $res->telefono  = $request->telefono;
        $res->codigo_proveedor  = $request->codigo_proveedor;
        $res->save();
        return response()->json($res);
    }
    //put
    public function update($id,Request $request){
        $res = Proveedores::findOrFail($id);
        $res->nombre = $request->nombre;
        $res->ruc = $request->ruc;
        $res->direccion = $request->direccion;
        $res->tipo  = $request->tipo;
        $res->correo_electronico = $request->correo_electronico;
        $res->responsable  = $request->responsable;
        $res->imagen_proveedores = $request->imagen_proveedores;
        if($request->imagen_proveedores == null){
            $res->imagen_proveedores = " ";
        }
        $res->telefono  = $request->telefono;
        $res->codigo_proveedor  = $request->codigo_proveedor;
        $res->save();
        return response()->json($res);
    }
    //delete
    public function destroy($id){
        Proveedores::findOrFail($id)->delete();
    }
}