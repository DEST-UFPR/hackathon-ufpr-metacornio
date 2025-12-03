<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesquisaDisciplina extends Model
{
    use HasFactory;

    protected $table = 'pesquisa_disciplina';

    protected $fillable = [
        'id_avaliacao',
        'id_pesquisa',
        'id_questionario',
        'questionario',
        'id_pergunta',
        'pergunta',
        'resposta',
        'situacao',
        'cod_disciplina',
        'nome_disciplina',
        'multipla_escolha',
        'modalidade',
        'cod_curso',
        'curso',
        'setor_curso',
        'departamento',
        'codprof',
    ];
}
