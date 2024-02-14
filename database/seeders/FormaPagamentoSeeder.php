<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormaPagamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $formasPagamento = [
            ['descricao' => 'Cartão de Crédito'],
            ['descricao' => 'Cartão de Débito'],
            ['descricao' => 'Pix'],
            ['descricao' => 'Dinheiro'],
            ['descricao' => 'Link de Pagamento'],
        ];

        // Inserir os dados na tabela 'forma_pagamento'
        DB::table('forma_pagamento')->insert($formasPagamento);
    }
}
