<?php

use App\Http\Controllers\AgendamentosController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController ; 
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\ServicosController;
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
        return view('agendamentos');
    }else{
        return view('login');
    }
});

//Login
Route::get('/login', function () {
    return view('login');
});
Route::get('logout' , [ AuthController::class , 'logout' ]); 
Route::post('login/authLogin' , [AuthController::class , 'postLogin']);
Route::post('login/authRegistrar', [ AuthController::class , 'postRegistrar']);


//Gerenciamento
Route::get('/gerenciamento', function () {
    if( session()->has('email') && session()->has('tipousuario')){
        return view('gerenciamento  ');
    }else{
        return view('login');
    }
});

//Servicos
Route::get('/servicos', function () {
    if( session()->has('email') && session()->has('tipousuario')){
        return view('servicos');
    }else{
        return view('login');
    }
});
Route::post('/servicos/cadastrarServicos' , [ServicosController::class , 'cadastrarServicos']); 


//Clientes
Route::get('/clientes' , [ ClientesController::class , 'index' ]); 
Route::post('/clientes/cadastrarClientes' , [ClientesController::class , 'cadastrarClientes']); 

//EditarAgendamentos 
Route::get('/editarAgendamentos/{id}' , [AgendamentosController::class , 'editarAgendamentos']);

//Rota Default
Route::fallback(function () {
    if( session()->has('email') && session()->has('tipousuario')){
        return view('agendamentos');
    }else{
        return view('login');
    }
});