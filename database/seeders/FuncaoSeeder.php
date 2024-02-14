<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FuncaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $funcao = [
            ['descricao' => 'Administrador'],
            ['descricao' => 'Proprietário'],
            ['descricao' => 'Gerente'],
            ['descricao' => 'Vendedor'],
            ['descricao' => 'Caixa'],
        ];

        // Inserir os dados na tabela 'funcao'
        DB::table('funcao')->insert($funcao);
    }
}
