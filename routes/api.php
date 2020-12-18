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
    Route::post('register', 'AuthController@signup');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');
    Route::post('recuperar', 'AuthController@cambiarContra');
    Route::post('cambiarNombre', 'AuthController@cambiarNombre');
    //Route::post('sendPasswordResetLink', 'ResetPasswordController@sendEmail');
    //Route::post('recuperar', 'AuthController@process');
    //-----------------------/API-JWT------------------------\\
        
    
});

    //-----------------------API-USER------------------------\\
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

    //-----------------------/API-USER------------------------\\

    
    //-----------------------API-PRODUCTOS------------------------\\
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

    //-----------------------/API-PRODUCTOS------------------------\\

    
    //-----------------------API-MATERIAS-PRIMAS------------------------\\
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
//-----------------------/API-MATERIAS-PRIMAS------------------------\\


    //-----------------------API-MATERIAS-EMPAQUE------------------------\\
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

    //-----------------------/API-MATERIAS-EMPAQUE------------------------\\


    
    //-----------------------API-PROVEEDORES------------------------\\
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
//-----------------------/API-PROVEEDORES------------------------\\



    //-----------------------API-INGRESO MATERIAS-PRIMAS------------------------\\

Route::group([
    'middleware' => 'api',
    'namespace'  => 'App\Http\Controllers',
], function ($router) {
    Route::get('ingresoMateriasPrimas', 'IngresosMateriasPrimasController@index');
    Route::get('ingresoMateriasPrimas/{id}', 'IngresosMateriasPrimasController@show');
    Route::get('ingresoMateriasPrimas2/{id}', 'IngresosMateriasPrimasController@show2');
    Route::delete('ingresoMateriasPrimas/{id}', 'IngresosMateriasPrimasController@destroy');
    Route::put('ingresoMateriasPrimas/{id}', 'IngresosMateriasPrimasController@update');
    Route::post('ingresoMateriasPrimas', 'IngresosMateriasPrimasController@create');
    Route::get('ingresoMateriasPrimasDetalles/{id}', 'InMatePrimasDetallesController@show');
});

    //-----------------------/API-INGRESO MATERIAS-PRIMAS------------------------\\


    //-----------------------API-INGRESO MATERIAS-EMPAQUE------------------------\\
Route::group([
    'middleware' => 'api',
    'namespace'  => 'App\Http\Controllers',
], function ($router) {
    Route::get('ingresosMaterialesEmpaques', 'IngresosMaterialesEmpaquesController@index');
    Route::get('ingresosMaterialesEmpaques/{id}', 'IngresosMaterialesEmpaquesController@show');
    Route::get('ingresosMaterialesEmpaques2/{id}', 'IngresosMaterialesEmpaquesController@show2');
    Route::delete('ingresosMaterialesEmpaques/{id}', 'IngresosMaterialesEmpaquesController@destroy');
    Route::put('ingresosMaterialesEmpaques/{id}', 'IngresosMaterialesEmpaquesController@update');
    Route::post('ingresosMaterialesEmpaques', 'IngresosMaterialesEmpaquesController@create');
    Route::get('ingresoMaterialesEmpaquesDetalles/{id}', 'InMateEmpaqueDetallesController@show');
});

    //-----------------------/API-INGRESO MATERIAS-EMPAQUE------------------------\\
Route::group([
    'middleware' => 'api',
    'namespace'  => 'App\Http\Controllers',
], function ($router) {
    Route::get('regulacionesProducto', 'RegulacionesController@index');
    Route::get('regulacionesPrima', 'RegulacionesController@index2');
    Route::get('regulacionesEmpaque', 'RegulacionesController@index3');
    Route::get('regulaciones/{id}', 'RegulacionesController@show');
    Route::post('regulaciones', 'RegulacionesController@create');
});

    
    //-----------------------API-CARRITO------------------------\\
Route::group([
    'middleware' => 'api',
    'namespace'  => 'App\Http\Controllers',
], function ($router) {
    Route::get('carritoDespachos', 'CarritoController@showListDespachos');
    Route::get('carritoProduccion', 'CarritoController@showListProduccion');
    Route::get('carritoRegulacion/{id}', 'CarritoController@showRegulacion');
    Route::post('carritoDespacho', 'CarritoController@createDespacho');
    Route::post('carritoProduccion', 'CarritoController@createProduccion');
    Route::post('carritoRegulacion', 'CarritoController@createRegulacion');
    Route::put('carritoDespachoProducto/{id}', 'CarritoController@updateProductoDespacho');
    Route::put('carritoProduccion/{id}', 'CarritoController@updatePrimaProduccion');
    Route::put('carritoDespachoEmpaque/{id}', 'CarritoController@updateEmpaqueDespacho');
    Route::put('carritoRegulacion/{id}', 'CarritoController@updateRegulacion');
    Route::delete('carrito/{id}', 'CarritoController@destroyDespacho');
});

    //-----------------------/API-CARRITO------------------------\\

    //-----------------------API-PRODUCTOS-DESPACHO------------------------\\
Route::group([
    'middleware' => 'api',
    'namespace'  => 'App\Http\Controllers',
], function ($router) {
    Route::get('productosDespachos', 'ProductosDespachosController@index');
    Route::get('productosDespachos/{id}', 'ProductosDespachosController@show');
    Route::post('productosDespachos', 'ProductosDespachosController@create');
    Route::get('productosDespachosDetails/{id}', 'ProductosDespachosDetallesController@show');
});

//-----------------------/API-PRODUCTOS-DESPACHO------------------------\\



Route::group([
    'middleware' => 'api',
    'namespace'  => 'App\Http\Controllers',
], function ($router) {
    Route::get('productosProduccion', 'ProductosElaboracionesController@index');
    Route::get('productosProduccion/{id}', 'ProductosElaboracionesController@show');
    Route::post('productosProduccion', 'ProductosElaboracionesController@create');
    Route::get('productosProduccionDetails/{id}', 'ProductosElaboracionesDetallesController@show');
    Route::get('productosProduccionDetails', 'ProductosElaboracionesDetallesController@index');
});

/******************************** */
Route::group([
    'middleware' => 'api',
    'namespace'  => 'App\Http\Controllers',
], function ($router) {
    Route::get('controlPrima', 'ControlInventariosController@index');
    Route::get('controlEmpaque', 'ControlInventariosController@index2');
    Route::get('controlProducto', 'ControlInventariosController@index3');
    Route::get('controlInvetario/{id}', 'ControlInventariosDetallesController@show');
    Route::put('controlInvetario/{id}', 'ControlInventariosDetallesController@update');
    Route::get('control/{id}', 'ControlInventariosController@show');
    Route::post('controlPrima', 'ControlInventariosController@createPrima');
    Route::post('controlEmpaque', 'ControlInventariosController@createEmpaque');
    Route::post('controlProducto', 'ControlInventariosController@createProducto');
    Route::get('controlFinish/{id}', 'ControlInventariosController@finishInventario');

    
});