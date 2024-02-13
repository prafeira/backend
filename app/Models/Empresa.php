<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pessoa;
use App\Models\Venda;

class Empresa extends Model
{
    use HasFactory;
    protected $table = 'empresa'; 
    
    protected $fillable = [
        'id',
        'nome', 
        'cnpj', 
        'endereco',
        'cor_tema',
        'data_cadastro',
        'data_encerramento',
        'situacao_empresa',
    ];

    public function pessoas()
    {
        return $this->hasMany(Pessoa::class, 'empresa_id');
    }

    public function vendas()
    {
        return $this->hasMany(Venda::class, 'empresa_id');
    }

}
