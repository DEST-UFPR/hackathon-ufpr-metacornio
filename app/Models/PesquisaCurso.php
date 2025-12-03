<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesquisaCurso extends Model
{
    use HasFactory;

    protected $table = 'pesquisa_curso';

    protected $fillable = [
        'id_avaliacao',
        'id_pesquisa',
        'id_pergunta',
        'id_questionario',
        'questionario',
        'pergunta',
        'resposta',
        'situacao',
        'multipla_escolha',
        'curso',
        'cod_curso',
        'setor_curso',
    ];
}
