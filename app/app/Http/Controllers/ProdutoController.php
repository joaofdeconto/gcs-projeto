<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProdutoController extends Controller
{
    public function index(): JsonResponse
    {
        $produtos = Produto::all();
        return response()->json($produtos);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nome'      => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco'     => 'required|numeric|min:0',
            'estoque'   => 'required|integer|min:0',
        ]);

        $produto = Produto::create($validated);
        return response()->json($produto, 201);
    }

    public function show(int $id): JsonResponse
    {
        $produto = Produto::findOrFail($id);
        return response()->json($produto);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $produto = Produto::findOrFail($id);

        $validated = $request->validate([
            'nome'      => 'sometimes|string|max:255',
            'descricao' => 'nullable|string',
            'preco'     => 'sometimes|numeric|min:0',
            'estoque'   => 'sometimes|integer|min:0',
        ]);

        $produto->update($validated);
        return response()->json($produto);
    }

    public function destroy(int $id): JsonResponse
    {
        $produto = Produto::findOrFail($id);
        $produto->delete();
        return response()->json(['message' => 'Produto removido com sucesso']);
    }
}
