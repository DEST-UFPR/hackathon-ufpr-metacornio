<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportPesquisa extends Model
{
    use HasFactory;
    public $table = "import_pesquisa";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome_usuario',
        'id_avaliacao',
        'caminho_arquivo',
        'nome_arquivo',
        'dados_importacao',
        'status_importacao',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'dados_importacao' => 'array',
    ];
}
