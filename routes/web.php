<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController ; 
use App\Http\Controllers\ClientesController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/





Route::get('/', function () {
    if( session()->has('email') && session()->has('tipousuario')){
        return view('paginaInicial');
    }else{
        return view('login');
    }
});

Route::get('/login', function () {
    return view('login');
});

Route::get('logout' , [ AuthController::class , 'logout' ]); 

Route::post('login/authLogin' , [AuthController::class , 'postLogin']);
Route::post('login/authRegistrar', [ AuthController::class , 'postRegistrar']);

Route::get('/gerenciamento', function () {
    if( session()->has('email') && session()->has('tipousuario')){
        return view('gerenciamento  ');
    }else{
        return view('login');
    }
});

Route::get('/servicos', function () {
    if( session()->has('email') && session()->has('tipousuario')){
        return view('servicos');
    }else{
        return view('login');
    }
});
Route::get('/clientes' , [ ClientesController::class , 'index' ]); 
Route::post('clientes/cadastrarClientes' , [ClientesController::class , 'cadastrarClientes']); 


Route::fallback(function () {
    if( session()->has('email') && session()->has('tipousuario')){
        return view('paginaInicial');
    }else{
        return view('login');
    }
});