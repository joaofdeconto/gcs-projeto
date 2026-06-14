<?php

namespace Tests\Feature;

use App\Models\Produto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProdutoApiTest extends TestCase
{
    use RefreshDatabase;

    // Teste 11
    public function test_listar_produtos_retorna_status_200(): void
    {
        $response = $this->getJson('/api/v1/produtos');
        $response->assertStatus(200);
    }

    // Teste 12
    public function test_listar_produtos_retorna_array(): void
    {
        Produto::create(['nome' => 'Produto A', 'preco' => 10.00, 'estoque' => 5]);
        $response = $this->getJson('/api/v1/produtos');
        $response->assertJsonIsArray();
    }

    // Teste 13
    public function test_criar_produto_retorna_status_201(): void
    {
        $response = $this->postJson('/api/v1/produtos', [
            'nome'    => 'Novo Produto',
            'preco'   => 99.90,
            'estoque' => 10,
        ]);
        $response->assertStatus(201);
    }

    // Teste 14
    public function test_criar_produto_persiste_no_banco(): void
    {
        $this->postJson('/api/v1/produtos', [
            'nome'    => 'Produto DB',
            'preco'   => 50.00,
            'estoque' => 3,
        ]);
        $this->assertDatabaseHas('produtos', ['nome' => 'Produto DB']);
    }

    // Teste 15
    public function test_criar_produto_sem_nome_retorna_422(): void
    {
        $response = $this->postJson('/api/v1/produtos', [
            'preco'   => 10.00,
            'estoque' => 1,
        ]);
        $response->assertStatus(422);
    }

    // Teste 16
    public function test_buscar_produto_existente_retorna_200(): void
    {
        $produto = Produto::create(['nome' => 'Produto X', 'preco' => 20.00, 'estoque' => 2]);
        $response = $this->getJson("/api/v1/produtos/{$produto->id}");
        $response->assertStatus(200);
    }

    // Teste 17
    public function test_buscar_produto_inexistente_retorna_404(): void
    {
        $response = $this->getJson('/api/v1/produtos/9999');
        $response->assertStatus(404);
    }

    // Teste 18
    public function test_atualizar_produto_retorna_200(): void
    {
        $produto = Produto::create(['nome' => 'Velho Nome', 'preco' => 10.00, 'estoque' => 1]);
        $response = $this->putJson("/api/v1/produtos/{$produto->id}", ['nome' => 'Novo Nome']);
        $response->assertStatus(200);
        $response->assertJsonFragment(['nome' => 'Novo Nome']);
    }

    // Teste 19
    public function test_deletar_produto_retorna_200(): void
    {
        $produto = Produto::create(['nome' => 'Para Deletar', 'preco' => 5.00, 'estoque' => 1]);
        $response = $this->deleteJson("/api/v1/produtos/{$produto->id}");
        $response->assertStatus(200);
    }

    // Teste 20
    public function test_health_check_retorna_status_ok(): void
    {
        $response = $this->getJson('/api/health');
        $response->assertStatus(200);
        $response->assertJsonFragment(['status' => 'ok']);
    }
}
