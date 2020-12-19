<?php

namespace App\Http\Controllers;

use App\Models\IngresosMaterialesEmpaques;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Carrito;
use App\Models\MaterialesEmpaques;
use App\Models\inMateEmpaqueDetalles;

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
        $date = Carbon::now();
        $res->fecha = $date;
        $res->nFactura = $request->nFactura;
        $res->proveedor_id  = $request->proveedor_id;
        $res->doc_completa  = $request->doc_completa;
        $res->observacion  = $request->observacion;
        $res->recibe  = auth()->user()->id;

        $tipo = "empaque";
        $user = auth()->user()->id;
        $carrito = Carrito::tipo($tipo)->user($user)
        ->join('materiales_empaques','carritos.empaque_id','=','materiales_empaques.id')
        ->select('carritos.id','carritos.cantidad_empaque','carritos.empaque_id','carritos.user_id',
        'materiales_empaques.nombre as materia_empaque_nombre','materiales_empaques.stock as materia_empaque_stock'
        ,'materiales_empaques.imagen_material_empaques as imagen_material_empaques','carritos.calidad as calidad','carritos.laminacion'
        ,'carritos.color as color')
        ->get();
        if (count($carrito) < 1) {
            return response()->json(array(
                'code'      =>  400,
                'message'   =>  "No se puedo crear ya que no cuenta con ningun producto"
            ), 400);
        }
        $res->save();

        foreach ($carrito as $data){
            $res2 = new inMateEmpaqueDetalles();
            $res2->cantidad_empaque = $data->cantidad_empaque;
            $res2->empaque_id   = $data->empaque_id;
            $res2->calidad  = $data->calidad;
            $res2->laminacion = $data->laminacion;
            $res2->color = $data->color;
            $res2->in_materiales_empaque_id   = $res->id;
            $producto = MaterialesEmpaques::findOrFail($res2->empaque_id);
            $producto->stock = $producto->stock +$res2->cantidad_empaque;
            $producto->save();
            $res2->save();
        }
        
        Carrito::tipo($tipo)->user($user)->delete();

        return response()->json($res);
    }
    //delete
    public function destroy($id){
        IngresosMaterialesEmpaques::findOrFail($id)->delete();
    }
}
