<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;

use Barryvdh\DomPDF\Facade as PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'filtro','destroy','show','update','show2','updateImagen']]);
    }
    public function index(Request $request)
    {
        $result = User::All();

        return response()->json($result); 
        
    }
    public function filtro(Request $request)
    {
        $nombre =$request->name;
        $users = User::name($nombre)->get();

        return response()->json($users);
       
    }
    public function show($id)
    {
        $usuario = User::findOrFail($id);
        return response()->json($usuario);
    }
    public function show2($id)
    {
        $usuario = User::where('users.id',$id)->get();
        return response()->json($usuario);
    }
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
    }
    public function update($id,Request $request)
    {
        $usuario = User::findOrFail($id);
        $usuario->email = $request->email;
        $usuario->name = $request->name;
        $usuario->rol = $request->rol;
        $usuario->autorizado  = $request->autorizado;
        $usuario->imagen_user = $request->imagen_user;
        if($request->imagen_user == null){
            $usuario->imagen_user = " ";
        }
        $usuario->save();
        return response()->json($usuario);
    }

    public function updateImagen($id,Request $request)
    {
        $usuario = User::findOrFail($id);
        $usuario->imagen_user = $request->imagen_user;
        if($request->imagen_user == null){
            $usuario->imagen_user = " ";
        }
        $usuario->save();
        return response()->json($usuario);
    }

}
