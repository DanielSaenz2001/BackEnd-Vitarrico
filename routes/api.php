<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Authorization,Origin, Content-Type, X-Auth-Token, X-XSRF-TOKEN');
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group([
    
    'middleware' => 'api',
    'namespace'  => 'App\Http\Controllers',
    'prefix'     => 'auth',


], function ($router) {
    //-----------------------API-JWT------------------------\\
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');
    Route::post('recuperar', 'AuthController@cambiarContra');
    Route::post('cambiarNombre', 'AuthController@cambiarNombre');
    //Route::post('sendPasswordResetLink', 'ResetPasswordController@sendEmail');
    //Route::post('recuperar', 'AuthController@process');
    //-----------------------/API-JWT------------------------\\
        
});
Route::group([
    'middleware' => 'api',
    'namespace'  => 'App\Http\Controllers',
], function ($router) {
    Route::get('user', 'UserController@index');
    Route::get('user/{id}', 'UserController@show');
    Route::get('user2/{id}', 'UserController@show2');
    Route::delete('user/{id}', 'UserController@destroy');
    Route::put('user/{id}', 'UserController@update');
    Route::post('user', 'UserController@filtro');
    Route::put('userImagen/{id}', 'UserController@updateImagen');

});

Route::group([
    'middleware' => 'api',
    'namespace'  => 'App\Http\Controllers',
], function ($router) {
    Route::get('productos', 'ProductosController@index');
    Route::get('productos/{id}', 'ProductosController@show');
    Route::get('productos2/{id}', 'ProductosController@show2');
    Route::delete('productos/{id}', 'ProductosController@destroy');
    Route::put('productos/{id}', 'ProductosController@update');
    Route::post('productosfiltro', 'ProductosController@filtro');
    Route::post('productos', 'ProductosController@create');
});
Route::group([
    'middleware' => 'api',
    'namespace'  => 'App\Http\Controllers',
], function ($router) {
    Route::get('mateprimas', 'MateriasPrimasController@index');
    Route::get('mateprimas/{id}', 'MateriasPrimasController@show');
    Route::get('mateprimas2/{id}', 'MateriasPrimasController@show2');
    Route::delete('mateprimas/{id}', 'MateriasPrimasController@destroy');
    Route::put('mateprimas/{id}', 'MateriasPrimasController@update');
    Route::post('mateprimasfiltro', 'MateriasPrimasController@filtro');
    Route::post('mateprimas', 'MateriasPrimasController@create');
});
Route::group([
    'middleware' => 'api',
    'namespace'  => 'App\Http\Controllers',
], function ($router) {
    Route::get('mateempaque', 'MaterialesEmpaquesController@index');
    Route::get('mateempaque/{id}', 'MaterialesEmpaquesController@show');
    Route::get('mateempaque2/{id}', 'MaterialesEmpaquesController@show2');
    Route::delete('mateempaque/{id}', 'MaterialesEmpaquesController@destroy');
    Route::put('mateempaque/{id}', 'MaterialesEmpaquesController@update');
    Route::post('mateempaquefiltro', 'MaterialesEmpaquesController@filtro');
    Route::post('mateempaque', 'MaterialesEmpaquesController@create');
});

Route::group([
    'middleware' => 'api',
    'namespace'  => 'App\Http\Controllers',
], function ($router) {
    Route::get('proveedores', 'ProveedoresController@index');
    Route::get('proveedores/{id}', 'ProveedoresController@show');
    Route::get('proveedores2/{id}', 'ProveedoresController@show2');
    Route::delete('proveedores/{id}', 'ProveedoresController@destroy');
    Route::put('proveedores/{id}', 'ProveedoresController@update');
    Route::post('proveedoresfiltro', 'ProveedoresController@filtro');
    Route::post('proveedores', 'ProveedoresController@create');
});