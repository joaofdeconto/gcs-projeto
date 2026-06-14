<?php

namespace Database\Seeders;

use App\Models\Produto;
use Illuminate\Database\Seeder;

class ProdutoSeeder extends Seeder
{
    public function run(): void
    {
        $produtos = [
            ['nome' => 'Notebook Dell', 'descricao' => 'Notebook i7 16GB RAM', 'preco' => 4500.00, 'estoque' => 10],
            ['nome' => 'Mouse Logitech', 'descricao' => 'Mouse sem fio', 'preco' => 150.00, 'estoque' => 50],
            ['nome' => 'Teclado Mecânico', 'descricao' => 'Teclado RGB switches blue', 'preco' => 350.00, 'estoque' => 30],
        ];

        foreach ($produtos as $produto) {
            Produto::create($produto);
        }
    }
}
