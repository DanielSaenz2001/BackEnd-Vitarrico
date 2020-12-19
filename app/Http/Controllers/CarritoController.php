<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use Illuminate\Http\Request;
use App\Models\Productos;
use App\Models\MaterialesEmpaques;
use App\Models\MateriasPrimas;
use App\Models\Regulaciones;

class CarritoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function showListDespachos(){
        $tipo = "despachos";
        $user = auth()->user()->id;
        $carrito = Carrito::tipo($tipo)->user($user)
        ->join('productos','carritos.producto_id','=','productos.id')
        ->join('materiales_empaques','carritos.empaque_id','=','materiales_empaques.id')
        ->select('carritos.id','productos.nombre as producto_nombre','productos.stock as productos_stock',
        'materiales_empaques.nombre as empaque_nombre','carritos.cantidad_producto as cantidad_producto' ,'carritos.cantidad_empaque as cantidad_empaque' 
         , 'materiales_empaques.stock as empaques_stock'
        ,'productos.imagen_producto as producto_imagen','materiales_empaques.imagen_material_empaques as empaque_imagen',
        'materiales_empaques.id as empaque_id', 'carritos.producto_id','carritos.empaque_id','carritos.user_id')
        ->get();
        return response()->json($carrito);
    }
    public function showListProduccion(){
        $tipo = "elaboracion";
        $user = auth()->user()->id;
        $resquest = Carrito::tipo($tipo)->user($user)
        ->join('materias_primas','carritos.materias_primas_id','=','materias_primas.id')
        ->select('carritos.id','carritos.cantidad_materias','carritos.materias_primas_id','carritos.user_id',
        'materias_primas.nombre as materia_prima_nombre','materias_primas.stock as materia_prima_stock'
        ,'materias_primas.imagen_materias_primas as materia_prima_imagen')
        ->get();
        return response()->json($resquest);
    }
    public function showRegulacion($id){
        $tipo = "regulacion";
        $user = auth()->user()->id;
        if($id == 1 ){
            $prima = Carrito::tipo($tipo)->user($user)->pri()
            ->join('users','carritos.user_id','=','users.id')
            ->join('materias_primas','carritos.materias_primas_id','=','materias_primas.id')
            ->select('carritos.id','carritos.cantidad_materias as cantidad_producto','materias_primas.nombre as producto_nombre'
            ,'materias_primas.imagen_materias_primas as producto_imagen','carritos.materias_primas_id')
            ->first();
            return response()->json($prima);
        }
        if($id == 2 ){
            $empaque = Carrito::tipo($tipo)->user($user)->emp()
            ->join('materiales_empaques','carritos.empaque_id','=','materiales_empaques.id')
            ->select('carritos.id','carritos.cantidad_empaque as cantidad_producto','materiales_empaques.nombre as producto_nombre'
            ,'materiales_empaques.imagen_material_empaques as producto_imagen','carritos.empaque_id')
            ->first();
            return response()->json($empaque);
        }
        if($id == 3 ){
            $producto = Carrito::tipo($tipo)->user($user)->pro()
            ->join('productos','carritos.producto_id','=','productos.id')
            ->select('carritos.id','carritos.cantidad_producto as cantidad_producto','productos.nombre as producto_nombre'
            ,'productos.imagen_producto as producto_imagen','carritos.producto_id')->first();  
            return response()->json($producto);
        }
    }
    public function showListInPrima(){
        $tipo = "prima";
        $user = auth()->user()->id;
        $resquest = Carrito::tipo($tipo)->user($user)
        ->join('materias_primas','carritos.materias_primas_id','=','materias_primas.id')
        ->select('carritos.id','carritos.cantidad_materias','carritos.materias_primas_id','carritos.user_id',
        'materias_primas.nombre as materia_prima_nombre','materias_primas.stock as materia_prima_stock'
        ,'materias_primas.imagen_materias_primas as materia_prima_imagen','carritos.integridad as integridad','carritos.plagas'
        ,'carritos.materias_extranas as materias_extranas')
        ->get();
        return response()->json($resquest);
    }

    public function showListInEmpaque(){
        $tipo = "empaque";
        $user = auth()->user()->id;
        $resquest = Carrito::tipo($tipo)->user($user)
        ->join('materiales_empaques','carritos.empaque_id','=','materiales_empaques.id')
        ->select('carritos.id','carritos.cantidad_empaque','carritos.empaque_id','carritos.user_id',
        'materiales_empaques.nombre as materia_empaque_nombre','materiales_empaques.stock as materia_empaque_stock'
        ,'materiales_empaques.imagen_material_empaques as imagen_material_empaques','carritos.calidad as calidad','carritos.laminacion'
        ,'carritos.color as color')
        ->get();
        return response()->json($resquest);
    }

    //post
    public function createProduccion(Request $request){
        $res = new Carrito();
        $res->materias_primas_id  = $request->materias_primas_id ;
        $res->cantidad_materias = 1;
        $res->tipo = "elaboracion";
        $res->user_id  = auth()->user()->id;
        $prima = MateriasPrimas::findOrFail($request->materias_primas_id);
        if($prima->stock -1  < 0){
            return response()->json(array(
                'code'      =>  406,
                'message'   =>  "No hay stock disponible en el almacen, comuniquele a su jefe lo mas antes posible."
            ), 406);
        }
        $prima->stock = $prima->stock - 1;
        $consulta = Carrito::tipo($res->tipo)->user($res->user_id)->prima($res->materias_primas_id)->first();
        if ($consulta !== null) {
            return response()->json(array(
                'code'      =>  400,
                'message'   =>  "Ya existe esa materia prima en la lista."
            ), 400);
        }
        $prima->save();
        $res->save();
        return response()->json($res);
    }
    public function createDespacho(Request $request){
        $res = new Carrito();
        $res->producto_id = $request->producto_id;
        $res->cantidad_producto = 1;
        $res->tipo = "despachos";
        $res->cantidad_empaque = 1;
        $res->user_id  = auth()->user()->id;
        $res->empaque_id  = 1;
        $producto = Productos::findOrFail($request->producto_id);
        $empaque = MaterialesEmpaques::findOrFail($res->empaque_id);
        if($producto->stock -1  < 0){
            return response()->json(array(
                'code'      =>  406,
                'message'   =>  "No hay stock disponible en el almacen, comuniquele a su jefe lo mas antes posible."
            ), 406);
        }
        if($empaque->stock -1  < 0){
            return response()->json(array(
                'code'      =>  406,
                'message'   =>  "No hay stock disponible en el almacen, comuniquele a su jefe lo mas antes posible."
            ), 406);
        }
        $producto->stock = $producto->stock - 1;
        $empaque->stock = $empaque->stock - 1;
        $consulta = Carrito::tipo($res->tipo)->user($res->user_id)->producto($res->producto_id)->first();
        error_log($consulta);
        if ($consulta !== null) {
            return response()->json(array(
                'code'      =>  400,
                'message'   =>  "Ya existe ese producto en la lista."
            ), 400);
        }
        $producto->save();
        $empaque->save();
        $res->save();
        return response()->json($res);
    }
    public function createRegulacion(Request $request){
        $prima=$request->materias_primas_id;
        $empaque=$request->empaque_id;
        $producto=$request->producto_id;
        if($prima !== 0){
            $res = new Carrito();
            $res->cantidad_materias = 1;
            $res->tipo = "regulacion";
            $res->materias_primas_id = $request->materias_primas_id;
            $res->user_id  = auth()->user()->id;
            $consulta = Carrito::tipo($res->tipo)->user($res->user_id)->pri()->first();
            if($consulta == null){
                $res->save();
            }else{
                $res = Carrito::findOrFail($consulta->id);
                $res->cantidad_materias = 1;
                $res->materias_primas_id  = $request->materias_primas_id;
                $res->save();
            }
        }
        if($empaque !== 0){
            $res = new Carrito();
            $res->cantidad_empaque = 1;
            $res->tipo = "regulacion";
            $res->empaque_id = $request->empaque_id;
            $res->user_id  = auth()->user()->id;
            $consulta = Carrito::tipo($res->tipo)->user($res->user_id)->emp()->first();
            if($consulta == null){
                $res->save();
            }else{
                $res = Carrito::findOrFail($consulta->id);
                $res->cantidad_empaque = 1;
                $res->empaque_id  = $request->empaque_id;
                $res->save();
            }
        }
        if($producto !== 0){
            $res = new Carrito();
            $res->cantidad_producto = 1;
            $res->tipo = "regulacion";
            $res->producto_id  = $request->producto_id;
            $res->user_id  = auth()->user()->id;
            $consulta = Carrito::tipo($res->tipo)->user($res->user_id)->pro()->first();
            if($consulta == null){
                $res->save();
            }else{
                $res = Carrito::findOrFail($consulta->id);
                $res->cantidad_producto = 1;
                $res->producto_id  = $request->producto_id;
                $res->save();
            }
        }
    }   

    public function createInPrima(Request $request){
        $res = new Carrito();
        $res->materias_primas_id  = $request->materias_primas_id;
        $res->cantidad_materias = 1;
        $res->materias_extranas = 0;
        $res->plagas = 0;
        $res->integridad = "Normal";
        $res->tipo = "prima";
        $res->user_id  = auth()->user()->id;
        $consulta = Carrito::tipo($res->tipo)->user($res->user_id)->prima($res->materias_primas_id)->first();
        if ($consulta !== null) {
            return response()->json(array(
                'code'      =>  400,
                'message'   =>  "Ya existe esa materia prima en la lista."
            ), 400);
        }
        $res->save();
        return response()->json($res);
    }
    public function createInEmpaque(Request $request){
        $res = new Carrito();
        $res->empaque_id  = $request->empaque_id;
        $res->cantidad_empaque  = 1;
        $res->calidad = "Normal";
        $res->laminacion = 0;
        $res->color = "Normal";
        $res->tipo = "empaque";
        $res->user_id  = auth()->user()->id;
        $consulta = Carrito::tipo($res->tipo)->user($res->user_id)->empaque($res->empaque_id)->first();
        if ($consulta !== null) {
            return response()->json(array(
                'code'      =>  400,
                'message'   =>  "Ya existe esa material en la lista."
            ), 400);
        }
        $res->save();
        return response()->json($res);
    }
    //put
    public function updateRegulacion($id,Request $request){
        $carrito = Carrito::findOrFail($id);
        $prima=$carrito->materias_primas_id;
        $empaque=$carrito->empaque_id;
        $producto=$carrito->producto_id;

        if($request->cantidad_producto <= 0){
            return response()->json(array(
                'code'      =>  406,
                'message'   =>  "La cantidad del producto deseado debe ser mayor a 0."
            ), 406);
        }
        if($prima !== null){
            $carrito->cantidad_materias = $request->cantidad_producto;
            $carrito->save();
        }
        if($empaque !== null){   
            $carrito->cantidad_empaque = $request->cantidad_producto;
            $carrito->save();
        }
        if($producto !== null){
            $carrito->cantidad_producto = $request->cantidad_producto;
            $carrito->save();
        }
    }
    public function updateProductoDespacho($id,Request $request){
        $carrito = Carrito::findOrFail($id);
        if($request->cantidad_producto < $carrito->cantidad_producto){
            $resultado= $carrito->cantidad_producto -$request->cantidad_producto;
            $producto = Productos::findOrFail($carrito->producto_id);
            $producto->stock = $producto->stock + $resultado;
            $producto->save();
        }
        if($request->cantidad_producto == 0){
            return response()->json(array(
                'code'      =>  400,
                'message'   =>  "La cantidad del producto no puede ser 0, le aconsejamos que lo elimine."
            ), 400);
        }
        if($request->cantidad_producto > $carrito->cantidad_producto){
            $resultado= $request->cantidad_producto - $carrito->cantidad_producto;
            $producto = Productos::findOrFail($carrito->producto_id);
            $producto->stock = $producto->stock - $resultado;
            if($producto->stock  < 0){
                return response()->json(array(
                    'code'      =>  406,
                    'message'   =>  "No hay stock disponible en el almacen, comuniquele a su jefe lo mas antes posible."
                ), 406);
            }
            $producto->save();
        }
        $carrito->cantidad_producto = $request->cantidad_producto;

        if($request->cantidad_empaque < $carrito->cantidad_empaque){
            $resultado= $carrito->cantidad_empaque -$request->cantidad_empaque;
            $empaque = MaterialesEmpaques::findOrFail($carrito->empaque_id);
            $empaque->stock = $empaque->stock + $resultado;
            $empaque->save();
        }
        if($request->cantidad_empaque == 0){
            return response()->json(array(
                'code'      =>  400,
                'message'   =>  "La cantidad del producto no puede ser 0, le aconsejamos que lo elimine."
            ), 400);
        }
        if($request->cantidad_empaque < $carrito->cantidad_empaque){
            $resultado= $carrito->cantidad_empaque -$request->cantidad_empaque;
            $empaque = MaterialesEmpaques::findOrFail($carrito->empaque_id);
            $empaque->stock = $empaque->stock + $resultado;
            $empaque->save();
        }
        if($request->cantidad_empaque > $carrito->cantidad_empaque){
            $resultado= $request->cantidad_empaque -$carrito->cantidad_empaque;
            $empaque = MaterialesEmpaques::findOrFail($carrito->empaque_id);
            $empaque->stock = $empaque->stock - $resultado;
            if($empaque->stock  < 0){
                return response()->json(array(
                    'code'      =>  406,
                    'message'   =>  "No hay stock disponible en el almacen, comuniquele a su jefe lo mas antes posible."
                ), 406);
            }
            $empaque->save();
        }
        $carrito->cantidad_empaque = $request->cantidad_empaque;


        $carrito->save();
        return response()->json($carrito);
    }
    public function updateEmpaqueDespacho($id,Request $request){
        $carrito = Carrito::findOrFail($id);
        $empaque = MaterialesEmpaques::findOrFail($carrito->empaque_id);
        $empaque->stock = $empaque->stock + $carrito->cantidad_empaque;
        $empaque->save();

        $carrito->empaque_id = $request->empaque_id;
        $empaque = MaterialesEmpaques::findOrFail($carrito->empaque_id);
        if($empaque->stock -1  < 0){
            return response()->json(array(
                'code'      =>  406,
                'message'   =>  "No hay stock disponible en el almacen, comuniquele a su jefe lo mas antes posible."
            ), 406);
        }
        $empaque->stock = $empaque->stock - 1;
        $empaque->save();

        $carrito->cantidad_empaque = 1;
        $carrito->save();
        return response()->json($carrito);
    }
    public function updatePrimaProduccion($id,Request $request){
        $carrito = Carrito::findOrFail($id);
        if($request->cantidad_materias < $carrito->cantidad_materias){
            $resultado= $carrito->cantidad_materias -$request->cantidad_materias;
            $prima = MateriasPrimas::findOrFail($carrito->materias_primas_id);
            $prima->stock = $prima->stock + $resultado;
            $prima->save();
        }
        if($request->cantidad_materias == 0){
            return response()->json(array(
                'code'      =>  400,
                'message'   =>  "La cantidad del producto no puede ser 0, le aconsejamos que lo elimine."
            ), 400);
        }
        if($request->cantidad_materias > $carrito->cantidad_materias){
            $resultado= $request->cantidad_materias - $carrito->cantidad_materias;
            $prima = MateriasPrimas::findOrFail($carrito->materias_primas_id);
            $prima->stock = $prima->stock - $resultado;
            if($prima->stock  < 0){
                return response()->json(array(
                    'code'      =>  406,
                    'message'   =>  "No hay stock disponible en el almacen, comuniquele a su jefe lo mas antes posible."
                ), 406);
            }
            $prima->save();
        }
        $carrito->cantidad_materias = $request->cantidad_materias;
        $carrito->save();
        return response()->json($carrito);
    }
    public function updatePrimaPrima($id,Request $request){
        $carrito = Carrito::findOrFail($id);
        if($request->cantidad_materias <= 0){
            return response()->json(array(
                'code'      =>  400,
                'message'   =>  "La cantidad del producto no puede ser menor o igual 0, le aconsejamos que lo elimine."
            ), 400);
        }


        $carrito->cantidad_materias = $request->cantidad_materias;
        $carrito->materias_extranas = $request->materias_extranas;
        $carrito->plagas = $request->plagas;
        $carrito->integridad = $request->integridad;
        $carrito->save();
        return response()->json($carrito);
    }
    public function updateEmpaqueEmpaque($id,Request $request){
        $carrito = Carrito::findOrFail($id);
        if($request->cantidad_empaque <= 0){
            return response()->json(array(
                'code'      =>  400,
                'message'   =>  "La cantidad del producto no puede ser menor o igual 0, le aconsejamos que lo elimine."
            ), 400);
        }

        $carrito->cantidad_empaque = $request->cantidad_empaque;
        $carrito->calidad = $request->calidad;
        $carrito->laminacion = $request->laminacion;
        $carrito->color = $request->color;
        $carrito->save();
        return response()->json($carrito);
    }
    //delete
    public function destroyDespacho($id){
        $carrito=Carrito::findOrFail($id);
        if( $carrito->tipo =="despachos"){
            $empaque = MaterialesEmpaques::findOrFail($carrito->empaque_id);
            $producto = Productos::findOrFail( $carrito->producto_id);
            $producto->stock = $producto->stock + $carrito->cantidad_producto;
            $empaque->stock = $empaque->stock + $carrito->cantidad_empaque;
            $producto->save();
            $empaque->save();
        }
        if( $carrito->tipo =="elaboracion"){
            $prima = MateriasPrimas::findOrFail($carrito->materias_primas_id);
            $prima->stock = $prima->stock + $carrito->cantidad_materias;
            $prima->save();
        }
        
        $carrito->delete();
    }
}
