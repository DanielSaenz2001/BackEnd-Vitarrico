<?php

namespace App\Http\Controllers;

use App\Models\ControlInventarios;
use Illuminate\Http\Request;
use App\Models\ControlInventariosDetalles;
use App\Models\MateriasPrimas;
use App\Models\MaterialesEmpaques;
use Carbon\Carbon;
use App\Models\Productos;
class ControlInventariosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(){
        $res = ControlInventarios::tipo("Prima")->estado("Finalizado")
        ->join('users','control_inventarios.responsable','=','users.id')
        ->select('control_inventarios.id','control_inventarios.fecha_inicio','control_inventarios.fecha_fin'
        ,'control_inventarios.tipo','users.name as responsable','users.imagen_user as imagen_user')
        ->get();
        return response()->json($res);
    }
    public function index2(){
        $res = ControlInventarios::tipo("Empaque")->estado("Finalizado")
        ->join('users','control_inventarios.responsable','=','users.id')
        ->select('control_inventarios.id','control_inventarios.fecha_inicio','control_inventarios.fecha_fin'
        ,'control_inventarios.tipo','users.name as responsable','users.imagen_user as imagen_user')
        ->get();
        return response()->json($res);
    }
    public function index3(){
        $res = ControlInventarios::tipo("Producto")->estado("Finalizado")
        ->join('users','control_inventarios.responsable','=','users.id')
        ->select('control_inventarios.id','control_inventarios.fecha_inicio','control_inventarios.fecha_fin'
        ,'control_inventarios.tipo','users.name as responsable','users.imagen_user as imagen_user')
        ->get();
        return response()->json($res);
    }
    public function show($id){
        $res = ControlInventarios::join('users','control_inventarios.responsable','=','users.id')
        ->where('control_inventarios.id','=',$id)
        ->select('control_inventarios.id','control_inventarios.fecha_inicio','control_inventarios.fecha_fin'
        ,'control_inventarios.tipo','users.name as responsable','users.imagen_user as imagen_user'
        ,'control_inventarios.estado')
        ->first();
        return response()->json($res);
    }
    public function createPrima(Request $request){
        $user=auth()->user()->id;
        $usuario = ControlInventarios::tipo("Prima")->estado("Proceso")->user($user)->first();
        $inventario = ControlInventarios::tipo("Prima")->estado("Proceso")->use($user)->first();
    
        if($inventario !== null){
            return response()->json(array(
                'code'      =>  406,
                'message'   =>  "Hay una control de inventario existente en este rubro porfavor llame al responsable que lo termine o cierre."
            ), 406);
        }
        if($usuario !== null){
            return response()->json($usuario,206);
        }
        $res = new ControlInventarios();
        $res->fecha_inicio=$request->fecha_inicio;
        $res->tipo="Prima";
        $res->estado="Proceso";
        $res->responsable =$user;
        $res->save();
        $productos = Productos::all();
        foreach ($productos as $data){
            $res2 = new ControlInventariosDetalles();
            $res2->estado  = "vigente";
            $res2->prima_id   = $data->id;
            $res2->control_inventarios_id   = $res->id;
            $res2->save();
        }
        
        return response()->json($res);
    }
    public function createEmpaque(Request $request){
        $user=auth()->user()->id;
        $usuario = ControlInventarios::tipo("Empaque")->estado("Proceso")->user($user)->first();
        $inventario = ControlInventarios::tipo("Empaque")->estado("Proceso")->use($user)->first();
        if($inventario !== null){
            return response()->json(array(
                'code'      =>  406,
                'message'   =>  "Hay una control de inventario existente en este rubro porfavor llame al responsable que lo termine o cierre."
            ), 406);
        }
        if($usuario !== null){
            return response()->json($usuario,206);
        }


        $res = new ControlInventarios();
        $res->fecha_inicio=$request->fecha_inicio;
        $res->tipo="Empaque";
        $res->estado="Proceso";
        $res->responsable =$user;
        $res->save();
        $empaque = MaterialesEmpaques::all();
        foreach ($empaque as $data){
            $res2 = new ControlInventariosDetalles();
            $res2->estado  = "vigente";
            $res2->empaque_id   = $data->id;
            $res2->control_inventarios_id   = $res->id;
            $res2->save();
        }
        return response()->json($res);
    }
    public function createProducto(Request $request){
        $user=auth()->user()->id;
        $usuario = ControlInventarios::tipo("Producto")->estado("Proceso")->user($user)->first();
        $inventario = ControlInventarios::tipo("Producto")->estado("Proceso")->use($user)->first();
        if($inventario !== null){
            return response()->json(array(
                'code'      =>  406,
                'message'   =>  "Hay una control de inventario existente en este rubro porfavor llame al responsable que lo termine o cierre."
            ), 406);
        }
        if($usuario !== null){
            return response()->json($usuario,206);
        }
        $res = new ControlInventarios();
        $res->fecha_inicio=$request->fecha_inicio;
        $res->tipo="Producto";
        $res->estado="Proceso";
        $res->responsable =$user;
        $res->save();
        $productos = Productos::all();
        foreach ($productos as $data){
            $res2 = new ControlInventariosDetalles();
            $res2->estado  = "vigente";
            $res2->producto_id   = $data->id;
            $res2->control_inventarios_id   = $res->id;
            $res2->save();
        }
        return response()->json($res);
    }
    public function finishInventario($id){
        $resquest = ControlInventariosDetalles::estado("vigente")->where('control_inventarios_detalles.control_inventarios_id','=',$id)
        ->first();
        if($resquest !== null){
            return response()->json(array(
                'code'      =>  400,
                'message'   =>  "Todovia tiene que revisar algunos productos."
            ), 400);
        }
        $res = ControlInventarios::estado("Proceso")->where('control_inventarios.id','=',$id)->first();
        if($res == null){
            return response()->json(array(
                'code'      =>  402,
                'message'   =>  "Ya termino"
            ), 402);
        }
        $date = Carbon::now();
        $res->fecha_fin=$date;
        $res->estado="Finalizado";
        $res->save();
    }
}
