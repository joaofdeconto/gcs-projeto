<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'descricao', 'preco', 'estoque'];

    protected $casts = [
        'preco' => 'decimal:2',
        'estoque' => 'integer',
    ];

    public function isDisponivel(): bool
    {
        return $this->estoque > 0;
    }

    public function aplicarDesconto(float $percentual): float
    {
        if ($percentual < 0 || $percentual > 100) {
            throw new \InvalidArgumentException('Percentual deve ser entre 0 e 100');
        }
        return $this->preco * (1 - $percentual / 100);
    }

    public function adicionarEstoque(int $quantidade): void
    {
        if ($quantidade <= 0) {
            throw new \InvalidArgumentException('Quantidade deve ser positiva');
        }
        $this->estoque += $quantidade;
    }

    public function removerEstoque(int $quantidade): void
    {
        if ($quantidade <= 0) {
            throw new \InvalidArgumentException('Quantidade deve ser positiva');
        }
        if ($quantidade > $this->estoque) {
            throw new \RuntimeException('Estoque insuficiente');
        }
        $this->estoque -= $quantidade;
    }
}
