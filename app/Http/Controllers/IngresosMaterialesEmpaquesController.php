<?php

namespace App\Http\Controllers;

use App\Models\IngresosMaterialesEmpaques;
use Illuminate\Http\Request;

class IngresosMaterialesEmpaquesController extends Controller
{
    
    public function index(){
        $resquest = IngresosMaterialesEmpaques::all();
        return response()->json($resquest);
    }
    public function show($id){
        $resquest= IngresosMaterialesEmpaques::findOrFail($id);
        return response()->json($resquest);
    }
    /*public function filtro(Request $request){
        $nombre =$request->nombre;
        error_log('Datos Enviados');
        error_log($request);
        $res = Productos::name($nombre)->get();
        error_log('Datos reenviados');
        error_log($res);
        return response()->json($res);
       
    }*/
    public function show2($id){
        $resquest = IngresosMaterialesEmpaques::where('ingresos_materiales_empaques.id',$id)->get();
        return response()->json($resquest);
    }
    //post
    public function create(Request $request){
        $res = new IngresosMaterialesEmpaques();
        $res->fecha = $request->fecha;
        $res->nFactura = $request->nFactura;
        $res->codigoEntrada = $request->codigoEntrada;
        $res->proveedor_id  = $request->proveedor_id;
        $res->fecha_fecha_venc = $request->fecha_fecha_venc;
        $res->producto_id  = $request->producto_id;
        $res->cantidad = $request->cantidad;
        $res->doc_completa  = $request->doc_completa;
        $res->fecha_elab  = $request->fecha_elab;
        $res->olor = $request->olor;
        $res->calidad_impresion  = $request->calidad_impresion;
        $res->textos = $request->textos;
        $res->laminacion  = $request->laminacion;
        $res->tamano = $request->tamano;
        $res->color  = $request->color;
        $res->lote = $request->lote;
        $res->observacion  = $request->observacion;
        $res->recibe  = $request->recibe;
        $res->save();
        return response()->json($res);
    }
    //put
    public function update($id,Request $request){
        $res = IngresosMaterialesEmpaques::findOrFail($id);
        $res->fecha = $request->fecha;
        $res->nFactura = $request->nFactura;
        $res->codigoEntrada = $request->codigoEntrada;
        $res->proveedor_id  = $request->proveedor_id;
        $res->fecha_fecha_venc = $request->fecha_fecha_venc;
        $res->producto_id  = $request->producto_id;
        $res->cantidad = $request->cantidad;
        $res->doc_completa  = $request->doc_completa;
        $res->fecha_elab  = $request->fecha_elab;
        $res->olor = $request->olor;
        $res->calidad_impresion  = $request->calidad_impresion;
        $res->textos = $request->textos;
        $res->laminacion  = $request->laminacion;
        $res->tamano = $request->tamano;
        $res->color  = $request->color;
        $res->lote = $request->lote;
        $res->observacion  = $request->observacion;
        $res->recibe  = $request->recibe;
        $res->save();
        return response()->json($res);
    }
    //delete
    public function destroy($id){
        IngresosMaterialesEmpaques::findOrFail($id)->delete();
    }
}
