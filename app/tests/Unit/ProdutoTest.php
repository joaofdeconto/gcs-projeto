<?php

namespace Tests\Unit;

use App\Models\Produto;
use Tests\TestCase;

class ProdutoTest extends TestCase
{
    private Produto $produto;

    protected function setUp(): void
    {
        parent::setUp();
        $this->produto = new Produto([
            'nome'     => 'Produto Teste',
            'descricao'=> 'Descrição teste',
            'preco'    => 100.00,
            'estoque'  => 10,
        ]);
    }

    // Teste 1
    public function test_produto_disponivel_quando_estoque_maior_que_zero(): void
    {
        $this->assertTrue($this->produto->isDisponivel());
    }

    // Teste 2
    public function test_produto_indisponivel_quando_estoque_zero(): void
    {
        $this->produto->estoque = 0;
        $this->assertFalse($this->produto->isDisponivel());
    }

    // Teste 3
    public function test_aplicar_desconto_calcula_corretamente(): void
    {
        $precoComDesconto = $this->produto->aplicarDesconto(10);
        $this->assertEquals(90.00, $precoComDesconto);
    }

    // Teste 4
    public function test_aplicar_desconto_zero_retorna_preco_original(): void
    {
        $precoComDesconto = $this->produto->aplicarDesconto(0);
        $this->assertEquals(100.00, $precoComDesconto);
    }

    // Teste 5
    public function test_aplicar_desconto_100_retorna_zero(): void
    {
        $precoComDesconto = $this->produto->aplicarDesconto(100);
        $this->assertEquals(0.00, $precoComDesconto);
    }

    // Teste 6
    public function test_desconto_invalido_lanca_excecao(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->produto->aplicarDesconto(150);
    }

    // Teste 7
    public function test_adicionar_estoque_incrementa_corretamente(): void
    {
        $this->produto->adicionarEstoque(5);
        $this->assertEquals(15, $this->produto->estoque);
    }

    // Teste 8
    public function test_adicionar_estoque_negativo_lanca_excecao(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->produto->adicionarEstoque(-1);
    }

    // Teste 9
    public function test_remover_estoque_decrementa_corretamente(): void
    {
        $this->produto->removerEstoque(3);
        $this->assertEquals(7, $this->produto->estoque);
    }

    // Teste 10
    public function test_remover_estoque_insuficiente_lanca_excecao(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->produto->removerEstoque(20);
    }
}
