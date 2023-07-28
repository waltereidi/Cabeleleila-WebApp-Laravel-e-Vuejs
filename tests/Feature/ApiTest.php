<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testeGetBuscaClientesDeveRetornarId()
    {
        $response = $this->get('/api/users?coluna=Nome&busca=Ray');

        $response->assertStatus(200);
        
    }

    public function testeGetClientesDeveRetornar200()
    {
        $response = $this->get('/api/clientes/getClientes');

        $response->assertStatus(200);
        
    }

    public function testePostModificarClientesDeveRetornar200()
    {
        $dados=[
            'id' => 1
        ];
            
        $response = $this->post('/api/clientes/modificarClientes' , $dados );

        $response->assertStatus(200);
        
    }
    public function testeDeleteClientesDeveRetornar200()
    {
        $response = $this->delete('/api/clientes/deleteClientes/199');
        $response->assertStatus(200);
        
    }

    public function testeGetServicosDeveRetornar200()
    {
        $response = $this->get('/api/servicos/getServicos');
        $response->assertStatus(200);
        
    }
    
    public function testeGetBuscaServicosDeveRetornar200()
    {
        $response = $this->get('/api/servicos/getBuscaServico/coluna=Nome&busca=corte');
        $response->assertStatus(200);
        
    }

    public function testeDeleteAgendamentosDeveRetornar200()
    {
        $response = $this->delete('api/agendamentos/deleteAgendamentos//199');
        $response->assertStatus(200);
        
    }
    public function testeGetBuscaClientesDeveRetornar200()
    {
        $response = $this->get('/api/agendamentos/getClientes');
        $response->assertStatus(200);
        
    }
    public function testeGetBuscaAgendamentosServicosDeveRetornar200()
    {
        $response = $this->get('/api/agendamentos/getServicos');
        $response->assertStatus(200);
        
    }
    public function testeGetPaginacaoAgendamentosDeveRetornar200()
    {
        $dados = [
            'inicio' => 0 
        ];
        $response = $this->post('/api/agendamentos/getAgendamentosPaginacao',$dados);
        $response->assertStatus(200);
        
    }
    public function testeGetAgendamentosSemanaDeveRetornar200()
    {
        $dados = [
            'clientes_id' => 1 
        ];
        $response = $this->post('/api/agendamentos/getAgendamentosSemana',$dados);
        $response->assertStatus(200);
        
    }

    public function testeGetCadastrarAgendamentosDeveRetornar200()
    {
        $dados = [
            'clientes_id' => 1 
        ];
        $response = $this->post('/api/agendamentos/cadastrarAgendamentos',$dados);
        $response->assertStatus(200);
        
    }
    public function testeGetAgendamentosDeveRetornar200()
    {
     
        $response = $this->get('/api/agendamentos/getAgendamentos');
        $response->assertStatus(200);
        
    }
    public function testeGetAgendamentosPaginacaoDeveRetornar200()
    {
        $response = $this->get('/api/agendamentos/getAgendamentosPaginacao');
        $response->assertStatus(200);
        
    }
    public function testeGetBuscaAgendamentosDeveRetornar200()
    {
        $response = $this->get('/api/agendamentos/getBuscaAgendamentos&busca=1&coluna=id');
        $response->assertStatus(200);
        
    }
    public function testeGetBuscaIntervalosAgendamentosDeveRetornar200()
    {
        $dados = [
            'clientes_id' => 1 
        ];
        $response = $this->post('/api/agendamentos/getBuscaIntervaloAgendamento');
        $response->assertStatus(200);
        
    }
    public function testeGetEditarAgendamentosDeveRetornar200()
    {
        
        $response = $this->get('/api/agendamentos/getEditarAgendamentos/1');
        $response->assertStatus(200);
        
    }

    public function testEditarAgendamentosDeveRetornar200()
    {
        $dados =[
            'id' => 1 
        ];
        $response = $this->post('/api/agendamentos/editarAgendamentos');
        $response->assertStatus(200);
        
    }
    public function testeGetGerenciamentosGraficoRendaMensalDeveRetornar200()
    {
        
        $response = $this->get('/api/gerenciamento/gerenciamentosGraficoRendaMensal');
        $response->assertStatus(200);
        
    }
    public function testeGetGerenciamentosGraficoRendaMensalIntervaloDeveRetornar200()
    {
        $dados =[
            'mesanoInicio' => '2023-01',
            'mesanoFim' => '2023-12'
        ];
        $response = $this->post('/api/gerenciamento/getGraficoAgendamentosMensalBusca');
        $response->assertStatus(200);
        
    }
    public function testeGetGerenciamentosGraficoArrecadamentoIntervaloDeveRetornar200()
    {
        $dados =[
            'mesanoInicio' => '2023-01',
            'mesanoFim' => '2023-12'
        ];
        $response = $this->post('/api/gerenciamento/getGraficoArrecadamentosMensalBusca');
        $response->assertStatus(200);
        
    }

}
