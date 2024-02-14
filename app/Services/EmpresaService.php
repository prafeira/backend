<?php

namespace App\Services;

use App\Models\Empresa;

class EmpresaService
{
    public function adicionarEmpresa(array $dados)
    {
        // Lógica para adicionar uma nova empresa
        $empresa = Empresa::create($dados);

        return $empresa;
    }

    public function editarEmpresa($id, array $dados)
    {
        // Lógica para editar uma empresa existente
        $empresa = Empresa::findOrFail($id);
        $empresa->update($dados);

        return $empresa;
    }

    public function deletarEmpresa($id)
    {
        // Lógica para excluir uma empresa do banco de dados
        $empresa = Empresa::findOrFail($id);
        $empresa->delete();

        return true; // Ou você pode retornar qualquer outro indicativo de sucesso
    }
}