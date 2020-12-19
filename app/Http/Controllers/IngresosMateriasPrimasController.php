<?php

namespace App\Http\Controllers;

use App\Models\IngresosMateriasPrimas;
use App\Models\Carrito;
use App\Models\InMatePrimasDetalles;
use Illuminate\Http\Request;
use App\Models\MateriasPrimas;
use Carbon\Carbon;

class IngresosMateriasPrimasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(){
        $resquest = IngresosMateriasPrimas::join('users','ingresos_materias_primas.recibe','=','users.id')
        ->join('proveedores','ingresos_materias_primas.proveedor_id','=','proveedores.id')
        ->select('ingresos_materias_primas.id','ingresos_materias_primas.fecha','ingresos_materias_primas.nFactura'
        ,'ingresos_materias_primas.doc_completa','ingresos_materias_primas.observacion',
        'users.name as recibe','proveedores.nombre as proveedor','proveedores.imagen_proveedores as proveedor_imagen')->get();
        return response()->json($resquest);
    }
    public function show($id){
        $resquest= IngresosMateriasPrimas::join('users','ingresos_materias_primas.recibe','=','users.id')
        ->join('proveedores','ingresos_materias_primas.proveedor_id','=','proveedores.id')
        ->where('ingresos_materias_primas.id','=',$id)
        ->select('ingresos_materias_primas.id','ingresos_materias_primas.fecha','ingresos_materias_primas.nFactura'
        ,'ingresos_materias_primas.doc_completa','ingresos_materias_primas.observacion',
        'users.name as recibe','proveedores.nombre as proveedor','proveedores.imagen_proveedores as proveedor_imagen')->first();
        return response()->json($resquest);
    }
    public function show2($id){
        $resquest = IngresosMateriasPrimas::where('ingresos_materias_primas.id',$id)->get();
        return response()->json($resquest);
    }
    //post
    public function create(Request $request){
        error_log($request);
        $res = new IngresosMateriasPrimas();
        $date = Carbon::now();
        $res->fecha = $date;
        $res->nFactura = $request->nFactura;
        $res->proveedor_id  = $request->proveedor_id;
        $res->doc_completa  = $request->doc_completa;
        $res->observacion  = $request->observacion;
        $res->recibe  = auth()->user()->id;
        $res->save();

        $tipo = "prima";
        $user = auth()->user()->id;
        $carrito = Carrito::tipo($tipo)->user($user)
        ->join('materias_primas','carritos.materias_primas_id','=','materias_primas.id')
        ->select('carritos.id','carritos.cantidad_materias','carritos.materias_primas_id','carritos.user_id',
        'materias_primas.nombre as materia_prima_nombre','materias_primas.stock as materia_prima_stock'
        ,'materias_primas.imagen_materias_primas as materia_prima_imagen','carritos.integridad as integridad','carritos.plagas'
        ,'carritos.materias_extranas as materias_extranas')
        ->get();
        if (count($carrito) < 1) {
            return response()->json(array(
                'code'      =>  400,
                'message'   =>  "No se puedo crear ya que no cuenta con ningun producto"
            ), 400);
        }
        $res->save();

        foreach ($carrito as $data){
            $res2 = new InMatePrimasDetalles();
            $res2->cantidad_prima = $data->cantidad_materias;
            $res2->prima_id  = $data->materias_primas_id;
            $res2->integridad  = $data->integridad;
            $res2->plagas = $data->plagas;
            $res2->materias_extranas = $data->materias_extranas;
            $res2->in_materias_prima_id  = $res->id;
            $producto = MateriasPrimas::findOrFail($res2->prima_id);
            $producto->stock = $producto->stock +$res2->cantidad_empaque;
            $producto->save();
            $res2->save();
        }
        
        Carrito::tipo($tipo)->user($user)->delete();
        return response()->json($res);
    }
    public function destroy($id){
        IngresosMateriasPrimas::findOrFail($id)->delete();
    }
}
