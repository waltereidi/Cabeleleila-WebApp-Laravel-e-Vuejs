<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Clientes; // Substitua pelo modelo relacionado à sua tabela
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\ServicoController ; 
use App\Http\Controllers\GerenciamentoController; 

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('clientes/getBuscaClientes', function (Request $request) {
    $parametros = $request->all();
    $retorno = null ;
        switch($parametros['coluna']){
             case 'Nome' :$retorno= Clientes::where( strtolower($parametros['coluna']) ,'ilike' ,  '%'.$parametros['busca'].'%')->get() ; break; 
             case 'Id' :$retorno= Clientes::where( strtolower($parametros['coluna']) , $parametros['busca'])->get() ; break; 
             case 'Email' :$retorno= Clientes::where( strtolower($parametros['coluna']) ,'ilike' ,  '%'.$parametros['busca'].'%')->get() ; break; 
             case 'Cpf' :$retorno= Clientes::where( strtolower($parametros['coluna']) ,'ilike' ,  '%'.$parametros['busca'].'%')->get() ; break; 
             case 'RG' :$retorno= Clientes::where( strtolower($parametros['coluna']) ,'ilike' ,  '%'.$parametros['busca'].'%')->get() ; break; 
             case 'Telefone' :$retorno= Clientes::where( strtolower($parametros['coluna']) ,'ilike' ,  '%'.$parametros['busca'].'%')->get() ; break; 
             case 'Telefone2' :$retorno= Clientes::where( strtolower($parametros['coluna']) ,'ilike' ,  '%'.$parametros['busca'].'%')->get() ; break; 
             case 'Observações' :$retorno= Clientes::where( strtolower($parametros['coluna']) ,'ilike' ,  '%'.$parametros['busca'].'%')->get() ; break; 
             case 'Data de nascimento' :$retorno= Clientes::where( strtolower($parametros['coluna']) ,'ilike' ,  '%'.$parametros['busca'].'%')->get() ; break; 
             case 'Criado Em' :$retorno= Clientes::where( strtolower($parametros['coluna']) , $parametros['busca'])->get() ; break; 
             case 'Ultima alteração' :$retorno= Clientes::where( strtolower($parametros['coluna']) ,  $parametros['busca'])->get() ; break; 
             default: return null ;break;
    }
    return  $retorno;
});

Route::get('clientes/getClientes', function () {
    return Clientes::limit(50)->get();
});

Route::get('clientes/getClientesPaginacao', function (Request $request ) {
    $parametros = $request->all();

    return Clientes::skip($parametros['inicio'])->limit(50)->get();
});

Route::delete('clientes/deleteClientes/{id}' , [ ClientesController::class ,'deletarCliente']);

Route::delete('clientes/deleteServico/{id}' , [ServicoController::class ,'deletarServico']);
Route::delete('clientes/deleteAgendamento/{id}' , [AgendamentoController::class ,'deletarAgendamento' ]);
Route::delete('clientes/deleteAgendamentoServico/{id}' , [ AgendamentoServicoController::class , 'deletarAgendamentoServico' ]);