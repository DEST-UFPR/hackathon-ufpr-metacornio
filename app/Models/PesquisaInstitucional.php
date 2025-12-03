<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesquisaInstitucional extends Model
{
    use HasFactory;

    protected $table = 'pesquisa_institucional';

    protected $fillable = [
        'id_avaliacao',
        'id_pesquisa',
        'id_questionario',
        'questionario',
        'id_pergunta',
        'pergunta',
        'resposta',
        'situacao',
        'lotacao',
        'sigla_lotacao',
    ];
}
