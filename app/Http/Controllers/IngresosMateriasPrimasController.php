<?php

namespace App\Http\Controllers;

use App\Models\IngresosMateriasPrimas;
use Illuminate\Http\Request;

class IngresosMateriasPrimasController extends Controller
{
    public function index(){
        $resquest = IngresosMateriasPrimas::all();
        return response()->json($resquest);
    }
    public function show($id){
        $resquest= IngresosMateriasPrimas::findOrFail($id);
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
        $resquest = IngresosMateriasPrimas::where('ingresos_materias_primas.id',$id)->get();
        return response()->json($resquest);
    }
    //post
    public function create(Request $request){
        $res = new IngresosMateriasPrimas();
        $res->fecha = $request->fecha;
        $res->nFactura = $request->nFactura;
        $res->codigoEntrada = $request->codigoEntrada;
        $res->proveedor_id  = $request->proveedor_id;
        $res->producto_id  = $request->producto_id;
        $res->cantidad = $request->cantidad;
        $res->doc_completa  = $request->doc_completa;
        $res->fecha_elab  = $request->fecha_elab;
        $res->fecha_fecha_venc = $request->fecha_fecha_venc;
        $res->integridad = $request->integridad;
        $res->ausencia_plaga  = $request->ausencia_plaga;
        $res->ausencia_extraña = $request->ausencia_extraña;
        $res->rotulado  = $request->rotulado;
        $res->caracteristicas = $request->caracteristicas;
        $res->lote = $request->lote;
        $res->observacion  = $request->observacion;
        $res->recibe  = $request->recibe;
        $res->save();
        return response()->json($res);
    }
    //put
    public function update($id,Request $request){
        $res = IngresosMateriasPrimas::findOrFail($id);
        $res->fecha = $request->fecha;
        $res->nFactura = $request->nFactura;
        $res->codigoEntrada = $request->codigoEntrada;
        $res->proveedor_id  = $request->proveedor_id;
        $res->producto_id  = $request->producto_id;
        $res->cantidad = $request->cantidad;
        $res->doc_completa  = $request->doc_completa;
        $res->fecha_elab  = $request->fecha_elab;
        $res->fecha_fecha_venc = $request->fecha_fecha_venc;
        $res->integridad = $request->integridad;
        $res->ausencia_plaga  = $request->ausencia_plaga;
        $res->ausencia_extraña = $request->ausencia_extraña;
        $res->rotulado  = $request->rotulado;
        $res->caracteristicas = $request->caracteristicas;
        $res->lote = $request->lote;
        $res->observacion  = $request->observacion;
        $res->recibe  = $request->recibe;
        $res->save();
        return response()->json($res);
    }
    //delete
    public function destroy($id){
        IngresosMateriasPrimas::findOrFail($id)->delete();
    }
}
