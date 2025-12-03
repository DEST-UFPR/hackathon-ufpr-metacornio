<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelaGeral extends Model
{
    use HasFactory;
    public $table = "tabela_geral";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tipo_dado',
        'valor_dado',
        'descricao_dado',
        'sequencia',
    ];
}
