<?php

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;

/**
 * Função para gerar código
 */
if(!function_exists("gerar_codigo"))
{
    function gerar_codigo($tipo_codigo)
    {
        $check = false;
        while($check == false){
            $codigo = strtoupper(Str::random(5));

            switch ($tipo_codigo) {
                case 'usuario':
                    $check_codigo = User::where("nome_usuario", $codigo)->count();
                break;
            }

            if($check_codigo == 0){
                $check = true;
            }
        }
        return $codigo;
    }
}

/**
 * Função de modulos
 */
if(!function_exists('modulos'))
{
    function modulos($info = null)
    {
        return collect( (object) array(
            (object) [ "name" => "cadastros", "title" => "Cadastros", "icon" => "fa-toolbox", ],
            (object) [ "name" => "estatisticas", "title" => "Estatísticas", "icon" => "fa-chart-column", ],
            (object) [ "name" => "administracao", "title" => "Administração", "icon" => "fa-user-secret", ],
        ));
    }
}

/**
 * Função de opções do menu
 */
if(!function_exists('opcoes_menu'))
{
    function opcoes_menu($info = null)
    {
        return collect( (object) array(
            /* Cadastros */
            (object) [ "modulo" => "cadastros", "route" => "avaliacao", "title" => "Avaliações", "icon" => "fa-clipboard-list", "temView" => true, ],

            /* Estatísticas */
            (object) [ "modulo" => "estatisticas", "route" => "estatisticaAlerta", "title" => "Alertas", "icon" => "fa-chart-pie-simple", "temView" => true, ],

            /* Admnistracao */
            (object) [ "modulo" => "administracao", "route" => "usuario", "title" => "Usuários", "icon" => "fa-users", "temView" => true, ],
            (object) [ "modulo" => "administracao", "route" => "tabelaGeral", "title" => "Dados Gerais", "icon" => "fa-brackets-curly", "temView" => true, ],
            (object) [ "modulo" => "administracao", "route" => "importarPesquisa", "title" => "Importar Pesquisa", "icon" => "fa-file-arrow-up", "temView" => true, ],

        ));
    }
}

/**
 * Função de Meses
 */
if(!function_exists('listaMeses'))
{
    function listaMeses($info = null)
    {
        return collect( (object) array(
            (object) [ "num" => "1", "nome" => "Janeiro", ],
            (object) [ "num" => "2", "nome" => "Fevereiro", ],
            (object) [ "num" => "3", "nome" => "Março", ],
            (object) [ "num" => "4", "nome" => "Abril", ],
            (object) [ "num" => "5", "nome" => "Maio", ],
            (object) [ "num" => "6", "nome" => "Junho", ],
            (object) [ "num" => "7", "nome" => "Julho", ],
            (object) [ "num" => "8", "nome" => "Agosto", ],
            (object) [ "num" => "9", "nome" => "Setembro", ],
            (object) [ "num" => "10", "nome" => "Outubro", ],
            (object) [ "num" => "11", "nome" => "Novembro", ],
            (object) [ "num" => "12", "nome" => "Dezembro", ],
        ));
    }
}

/**
 * Lista de Status de Pesquisa
 */
if(!function_exists('listaStatusPesquisa'))
{
    function listaStatusPesquisa($info = null)
    {
        return collect( (object) array(
            (object) [ "codigo" => "A", "nome" => "Aberta", ],
            (object) [ "codigo" => "F", "nome" => "Finalizada", ],
            (object) [ "codigo" => "C", "nome" => "Cancelada", ],
        ));
    }
}

/**
 * Lista de Categorias de Pesquisa
 */
if(!function_exists('listaCategoriasPesquisa'))
{
    function listaCategoriasPesquisa($info = null)
    {
        return collect( (object) array(
            (object) [ "codigo" => "Departamento", "nome" => "Departamento", ],
            (object) [ "codigo" => "EAD", "nome" => "Disciplina EAD", ],
            (object) [ "codigo" => "Presencial", "nome" => "Disciplina Presencial", ],
            (object) [ "codigo" => "Curso", "nome" => "Curso", ],
            (object) [ "codigo" => "Iniciação Científica e Tecnológica", "nome" => "Iniciação Científica e Tecnológica", ],
            (object) [ "codigo" => "Institucional", "nome" => "Institucional", ],
            (object) [ "codigo" => "Pós-Graduação", "nome" => "Pós-Graduação", ],
            (object) [ "codigo" => "Professor", "nome" => "Professor", ],
        ));
    }
}