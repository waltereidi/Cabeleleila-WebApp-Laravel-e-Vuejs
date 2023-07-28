<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gerenciamento;

class GerenciamentoController extends Controller
{
    //
    public function gerenciamentosGraficoRendaMensal(){
        $gerenciamento = new Gerenciamento();
        
        return $gerenciamento->gerenciamentosGraficoRendaMensal();
        
    }
    public function getGraficoAgendamentosMensalBusca(Request $request ){
        $gerenciamento = new Gerenciamento();
        
        $parametros = $request->all();
        return $gerenciamento->getGraficoAgendamentosMensalBusca($parametros);
        
    }
    public function getGraficoArrecadamentosMensalBusca(Request $request ){
        $gerenciamento = new Gerenciamento();
        
        $parametros = $request->all();
        return $gerenciamento->getGraficoArrecadamentosMensalBusca($parametros);
        
    }
}
