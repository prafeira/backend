<?php

namespace App\Services;

use App\Models\Venda;

class VendaService
{
    public function adicionarVenda(array $dados)
    {
        // Lógica para adicionar uma nova venda, se necessário
        $venda = Venda::create($dados);

        return $venda;
    }

    public function editarVenda($id, array $dados)
    {
        $venda = Venda::findOrFail($id);

        // Lógica para editar a venda, se necessário
        $venda->update($dados);

        return $venda;
    }

    public function deletarVenda($id)
    {
        $venda = Venda::findOrFail($id);

        // Lógica para deletar a venda, se necessário
        $venda->delete();
    }

    public function listarVendas()
    {
        // Lógica para obter a lista de vendas, se necessário
        $vendas = Venda::all();

        return $vendas;
    }

    public function listarVendasPorPessoa($idPessoa)
    {
        // Lógica para obter a lista de vendas, se necessário
        $vendas = Venda::where('pessoa_id', '=', $idPessoa)->get();

        return $vendas;
    }

    public function listarVendasPorEmpresa($idEmpresa)
    {
        // Lógica para obter a lista de vendas, se necessário
        $vendas = Venda::where('empresa_id', '=', $idEmpresa)->get();

        return $vendas;
    }

    public function obterDetalhesVenda($id)
    {
        // Lógica para obter detalhes específicos da venda, se necessário
        $venda = Venda::findOrFail($id);

        return $venda;
    }
}