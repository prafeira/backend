<?php

namespace App\Services;

use App\Models\Pessoa;

class PessoaService
{
    public function adicionarPessoa(array $dados): Pessoa
    {
        return Pessoa::create($dados);
    }

    public function editarPessoa(int $id, array $dados): Pessoa
    {
        $pessoa = Pessoa::findOrFail($id);
        $pessoa->update($dados);

        return $pessoa;
    }

    public function deletarPessoa(int $id): void
    {
        Pessoa::findOrFail($id)->delete();
    }
}