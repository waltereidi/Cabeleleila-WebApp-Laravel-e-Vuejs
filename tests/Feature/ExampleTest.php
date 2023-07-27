<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testListaClientes()
    {
        // Use a função `get` para fazer uma requisição GET para a rota de listagem de usuários
        $response = $this->get('/api/clientes/getClientes');

        // Verifica se a resposta tem status HTTP 200 (OK)
        $response->assertStatus(200);

        // Verifica se a resposta é em formato JSON

        // Verifica se a resposta contém a estrutura esperada (por exemplo, se contém uma chave 'data' com os usuários)
    
    }
}
