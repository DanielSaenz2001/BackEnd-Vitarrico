<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Carrito;
use App\Models\ProductosDespachos;
use App\Models\ProductosDespachosDetalles;

class ProductosDespachosController extends Controller{
    
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(){
        $res = ProductosDespachos::all();
        return response()->json($res);
    }
    public function show($id){
        $res= ProductosDespachos::join('users','productos_despachos.responsable','=','users.id')
        ->where('productos_despachos.id','=',$id)
        ->select('productos_despachos.id','productos_despachos.vehiculo','productos_despachos.nombreConductor','productos_despachos.fecha'
        ,'productos_despachos.ciudadDestino','productos_despachos.responsable','users.name as responsable_nombre')->first();
        return response()->json($res);
    }
    //post
    public function create(Request $request){
       
       
        $res = new ProductosDespachos();
        $res->vehiculo = $request->vehiculo;
        $res->nombreConductor = $request->nombreConductor;
        $res->fecha = $request->fecha;
        $res->ciudadDestino = $request->ciudadDestino;
        $res->responsable  = auth()->user()->id;
        

        
        
        //$user = $request->user_id;
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
        error_log("holii weeey");
        if (count($carrito) < 1) {
            return response()->json(array(
                'code'      =>  400,
                'message'   =>  "No se puedo crear ya que no cuenta con ningun producto"
            ), 400);
        }
        $res->save();
        
        foreach ($carrito as $data ){
            $res2 = new ProductosDespachosDetalles();
            $res2->cantidad_producto = $data->cantidad_producto;
            $res2->cantidad_empaque = $data->cantidad_empaque;
            $res2->material_empaque_id  = $data->empaque_id;
            $res2->producto_id = $data->producto_id;
            $res2->productos_despachos_id = $res->id;
            $res2->save();
        }
        Carrito::tipo($tipo)->user($user)->delete();

        return response()->json($res);
    }
}