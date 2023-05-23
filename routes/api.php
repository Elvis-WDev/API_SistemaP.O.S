<?php

use App\Http\Controllers\assets\GetInfoData;
use App\Http\Controllers\auth\ControllerAuth;
use App\Http\Controllers\ControllerCategoria;
use App\Http\Controllers\ControllerClientes;
use App\Http\Controllers\ControllerPDF;
use App\Http\Controllers\ControllerProductos;
use App\Http\Controllers\ControllerUser;
use App\Http\Controllers\ControllerVentas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Registrar usuario
Route::post('save-users', [ControllerAuth::class, 'register_user']);
// Logear usuario
Route::post('login', [ControllerAuth::class, 'login_user']);
// Renovar Token
Route::middleware('jwt.verify')->post('/renew', [ControllerAuth::class, 'renew_token']);

Route::middleware('jwt.verify')->group(function () {
    // USUARIOS
    Route::get('get-users', [ControllerUser::class, 'index'])->middleware('jwt.verify');
    Route::post('update-users', [ControllerAuth::class, 'update_user'])->middleware('jwt.verify');
    // Route::put('update-users/{id}', [ControllerAuth::class, 'update_user'])->middleware('jwt.verify');
    Route::delete('delete-users/{id}', [ControllerAuth::class, 'delete_user'])->middleware('jwt.verify');
    // CLIENTES
    Route::get('get-clientes', [ControllerClientes::class, 'index'])->middleware('jwt.verify');
    Route::post('save-clientes', [ControllerClientes::class, 'store'])->middleware('jwt.verify');
    Route::put('update-clientes/{id}', [ControllerClientes::class, 'update'])->middleware('jwt.verify');
    Route::delete('delete-clientes/{id}', [ControllerClientes::class, 'destroy'])->middleware('jwt.verify');
    // CATEGORIAS
    Route::get('get-categorias', [ControllerCategoria::class, 'index'])->middleware('jwt.verify');
    Route::post('save-categorias', [ControllerCategoria::class, 'store'])->middleware('jwt.verify');
    Route::put('update-categorias/{id}', [ControllerCategoria::class, 'update'])->middleware('jwt.verify');
    Route::delete('delete-categorias/{id}', [ControllerCategoria::class, 'destroy'])->middleware('jwt.verify');
    // Productos
    Route::get('get-productos', [ControllerProductos::class, 'index'])->middleware('jwt.verify');
    Route::post('save-productos', [ControllerProductos::class, 'store'])->middleware('jwt.verify');
    Route::post('update-productos', [ControllerProductos::class, 'update'])->middleware('jwt.verify');
    Route::delete('delete-productos/{id}', [ControllerProductos::class, 'destroy'])->middleware('jwt.verify');
    // VENTAS
    Route::get('get-ventas', [ControllerVentas::class, 'index'])->middleware('jwt.verify');
    Route::post('save-ventas', [ControllerVentas::class, 'store'])->middleware('jwt.verify');
    Route::put('update-ventas/{id_venta}', [ControllerVentas::class, 'update'])->middleware('jwt.verify');
    Route::delete('delete-ventas/{id}', [ControllerVentas::class, 'destroy'])->middleware('jwt.verify');
    Route::get('get-info/{data}', [GetInfoData::class, 'GetInfo'])->middleware('jwt.verify');
});
