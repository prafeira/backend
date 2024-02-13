<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pessoa;
use App\Models\Empresa;

class Venda extends Model
{
    use HasFactory;
    protected $table = 'venda'; 
    
    protected $fillable = [
        'id', 
        'valor',
        'forma_pagamento_id', 
        'situacao_pagamento', 
        'data_registro', 
        'pessoa_id', 
        'empresa_id', 
        'desconto'
    ];

        // Relacionamento com a tabela Pessoa
        public function pessoa()
        {
            return $this->belongsTo(Pessoa::class, 'pessoa_id');
        }
    
        // Relacionamento com a tabela Empresa
        public function empresa()
        {
            return $this->belongsTo(Empresa::class, 'empresa_id');
        }
}
