<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Http\Requests\SignUpRequest;
use App\Models\User;
//use DB;
//use App\RolesUser;
//use App\Egresados;
//use App\Distritos;
//use App\EgresadosEscuelas;
use Illuminate\Http\Request;

class AuthController extends Controller
{
      /**
     * Create a new AuthController instance. 
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'El Correo o la contraseña estan erroneos.'], 401);
        }
        //auth()->factory()->getTTL() = 36000;
        return $this->respondWithToken($token);
    }

    public function cambiarContra(Request $request)
    {
        $credentials = request(['email','password']);
        if($token = auth()->attempt($credentials)){
            if($request->password_new == $request->password_confirmation){
                $user = User::whereEmail(auth()->user()->email)->first();
                $user->update(['password'=>$request->password_new]);
                return response()->json(['data'=>'Password Successfully Changed']);
            }
            return response()->json(['data'=>'Password Successfully Changed'],300);
        }
        return response()->json(['data'=>'Password Successfully Changed'],401);
    }

    
    public function cambiarNombre(Request $request){
        $user = User::whereEmail(auth()->user()->email)->first();
        $user->update(['name'=>$request->name]);
    }
  

    public function register(SignUpRequest $request)
    {
        $user = new User();
        $user->email = $request->email;
        $user->password = $request->password;
        $user->name = $request->name;
        $user->rol = $request->rol;
        $user->autorizado  = $request->autorizado;
        $user->imagen_user= $request->imagen_user;
        $user->save();
    }

  

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL(),
            'user' => auth()->user()->id
        ]);
    }
    
}