<?php

namespace App\Http\Controllers;

use App\Models\IngresosMaterialesEmpaques;
use Illuminate\Http\Request;

class IngresosMaterialesEmpaquesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(){
        $resquest = IngresosMaterialesEmpaques::join('users','ingresos_materiales_empaques.recibe','=','users.id')
        ->join('proveedores','ingresos_materiales_empaques.proveedor_id','=','proveedores.id')
        ->select('ingresos_materiales_empaques.id','ingresos_materiales_empaques.fecha','ingresos_materiales_empaques.nFactura'
        ,'ingresos_materiales_empaques.doc_completa','ingresos_materiales_empaques.observacion',
        'users.name as recibe','proveedores.nombre as proveedor','proveedores.imagen_proveedores as proveedor_imagen')->get();
        return response()->json($resquest);
    }
    public function show($id){
        $resquest= IngresosMaterialesEmpaques::join('users','ingresos_materiales_empaques.recibe','=','users.id')
        ->join('proveedores','ingresos_materiales_empaques.proveedor_id','=','proveedores.id')
        ->where('ingresos_materiales_empaques.id','=',$id)
        ->select('ingresos_materiales_empaques.id','ingresos_materiales_empaques.fecha','ingresos_materiales_empaques.nFactura'
        ,'ingresos_materiales_empaques.doc_completa','ingresos_materiales_empaques.observacion',
        'users.name as recibe','proveedores.nombre as proveedor','proveedores.imagen_proveedores as proveedor_imagen')->first();;
        return response()->json($resquest);
    }
    public function create(Request $request){
        $res = new IngresosMaterialesEmpaques();
        $res->fecha = $request->fecha;
        $res->nFactura = $request->nFactura;
        $res->proveedor_id  = $request->proveedor_id;
        $res->doc_completa  = $request->doc_completa;
        $res->observacion  = $request->observacion;
        $res->recibe  = auth()->user()->id;
        $res->save();
        return response()->json($res);
    }
    //delete
    public function destroy($id){
        IngresosMaterialesEmpaques::findOrFail($id)->delete();
    }
}
