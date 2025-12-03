<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avaliacao extends Model
{
    use HasFactory;

    protected $table = 'avaliacao';

    protected $fillable = [
        'nome_avaliacao',
        'categoria_avaliacao',
        'semestre_avaliacao',
        'ano_avaliacao',
        'periodo_label',
        'status_avaliacao',
    ];
}
