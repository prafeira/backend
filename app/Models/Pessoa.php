<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\Funcao;
use App\Models\Venda;

class Pessoa extends Model implements Authenticatable
{
    use AuthenticableTrait, HasApiTokens, HasFactory, Notifiable;

    protected $table = 'pessoa'; 
    
    protected $fillable = [
        'id', 
        'nome',
        'cpf', 
        'funcao_id', 
        'comissao', 
        'telefone', 
        'data_admissao', 
        'data_desligamento', 
        'empresa_id',
        'name',
        'email',
        'password',
        'created_at', 
        'updated_at', 
        'empresa_id'
    ];

    public function funcao()
    {
        return $this->belongsTo(Funcao::class, 'funcao_id','id');
    }

    public function vendas()
    {
        return $this->hasMany(Venda::class, 'pessoa_id');
    }
}
