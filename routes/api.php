<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Clientes; 
use App\Http\Controllers\ClientesController;


use App\Http\Controllers\ServicosController ; 
use App\Models\Servicos;

use App\Http\Controllers\AgendamentosController; 
use App\Models\Agendamentos ; 

use App\Http\Controllers\AgendamentoServicosController; 
use App\Model\AgendamentoServicos;

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
//Clientes
Route::get('clientes/getBuscaClientes', function (Request $request) {
    $parametros = $request->all();
    $retorno = null ;
        switch($parametros['coluna']){
             case 'Nome' :$retorno= Clientes::where( strtolower($parametros['coluna']) ,'ilike' ,  '%'.$parametros['busca'].'%')->get() ; break; 
             case 'Id' :$retorno= Clientes::where( strtolower($parametros['coluna']) , $parametros['busca'])->get() ; break; 
             case 'Email' :$retorno= Clientes::where( strtolower($parametros['coluna']) ,'ilike' ,  '%'.$parametros['busca'].'%')->get() ; break; 
             case 'Cpf' :$retorno= Clientes::where( strtolower($parametros['coluna']) ,'ilike' ,  '%'.$parametros['busca'].'%')->get() ; break; 
             case 'Rg' :$retorno= Clientes::where( strtolower($parametros['coluna']) ,'ilike' ,  '%'.$parametros['busca'].'%')->get() ; break; 
             case 'Telefone' :$retorno= Clientes::where( strtolower($parametros['coluna']) ,'ilike' ,  '%'.$parametros['busca'].'%')->get() ; break; 
             case 'Telefone2' :$retorno= Clientes::where( strtolower($parametros['coluna']) ,'ilike' ,  '%'.$parametros['busca'].'%')->get() ; break; 
             case 'Observacoes' :$retorno= Clientes::where( strtolower($parametros['coluna']) ,'ilike' ,  '%'.$parametros['busca'].'%')->get() ; break; 
             case 'Data de nascimento' :$retorno= Clientes::where( strtolower($parametros['coluna']) ,'ilike' ,  '%'.$parametros['busca'].'%')->get() ; break; 
             case 'Criado em' :$retorno= Clientes::where( strtolower($parametros['coluna']) , $parametros['busca'])->get() ; break; 
             case 'Ultima alteracao' :$retorno= Clientes::where( strtolower($parametros['coluna']) ,  $parametros['busca'])->get() ; break; 
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

Route::post('clientes/modificarClientes' , [ClientesController::class , 'modificarClientes'] );
Route::delete('clientes/deleteClientes/{id}' , [ ClientesController::class ,'deletarClientes']);


//Servicos
Route::get('servicos/getServicos', function () {
    return Servicos::limit(50)->get();
});
Route::get('servicos/getBuscaServicos', function (Request $request) {
    $parametros = $request->all();
    $retorno = null ;
        switch($parametros['coluna']){
             case 'Nome' :$retorno= Servicos::where( strtolower($parametros['coluna']) ,'ilike' ,  '%'.$parametros['busca'].'%')->get() ; break; 
             case 'Id' :$retorno= Servicos::where( strtolower($parametros['coluna']) , $parametros['busca'])->get() ; break; 
             case 'Descricao' :$retorno= Servicos::where( strtolower($parametros['coluna']) ,'ilike' ,  '%'.$parametros['busca'].'%')->get() ; break; 
             case 'Tempoestimado' :$retorno= Servicos::whereTime( strtolower($parametros['coluna']),'=' ,$parametros['busca'])->get() ; break; 
             case 'Preco' :$retorno= Servicos::where( strtolower($parametros['coluna']) ,  $parametros['busca'] )->get() ; break; 
             case 'Criado em' :$retorno= Servicos::where( strtolower($parametros['coluna']) , $parametros['busca'])->get() ; break; 
             case 'Ultima alteracao' :$retorno= Servicos::where( strtolower($parametros['coluna']) ,  $parametros['busca'])->get() ; break; 
             default: return null ;break;
    }
    return  $retorno;
});

Route::delete('servicos/deleteServicos/{id}' , [ ServicosController::class ,'deletarServicos']);
Route::post('servicos/modificarServicos' , [ServicosController::class , 'modificarServicos'] );
Route::get('servicos/getServicosPaginacao', function (Request $request ) {
    $parametros = $request->all();

    return Servicos::skip($parametros['inicio'])->limit(50)->get();
});

//Agendamentos
Route::delete('agendamentos/deleteAgendamentos/{id}' , [AgendamentosController::class ,'deletarAgendamento' ]);
Route::get('agendamentos/getClientes'  , function(){
    return Clientes::select('id' , 'nome', 'telefone' )->get();
}) ;
Route::get('agendamentos/getServicos' , function(){
    return Servicos::select('id' , 'nome' , 'preco' , 'tempoestimado')->get();
});
Route::post('agendamentos/getAgendamentosPaginacao' , function(Request $request){
    $parametros = $request->all(); 
    return Agendamentos::skip($parametros['inicio'])->limit(50)->get();
});
Route::post('agendamentos/getAgendamentosSemana',[ AgendamentosController::class , 'getAgendamentosSemana']);
Route::post('agendamentos/cadastrarAgendamentos',[ AgendamentosController::class , 'cadastrarAgendamentos']);
Route::get('agendamentos/getAgendamentos' , [ AgendamentosController::class  , 'getAgendamentos'] ); 
Route::get('agendamentos/getAgendamentosPaginacao' , [ AgendamentosController::class , 'getAgendamentosPaginacao']  );
Route::get('agendamentos/getBuscaAgendamentos' , [ AgendamentosController::class  , 'getBuscaAgendamentos'] );


//Gerenciamento
Route::delete('clientes/deleteAgendamentoServico/{id}' , [ AgendamentosServicoController::class , 'deletarAgendamentoServico' ]);