<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Avaliacao;
use Illuminate\Http\Request;

class ViewsController extends Controller
{
    ######################################### PEGAR A ROTA DA REQUISIÇÃO ############################################
    # $urlRequest = url()->previous();                                                                              #
    # $routeRequest = app('router')->getRoutes($urlRequest)->match(app('request')->create($urlRequest))->getName(); #
    #################################################################################################################

    # PAGINA INICIAL
    public function index(Request $request)
    {
        $seo = json_decode(json_encode([
            'title' => 'Hackathon UFPR',
            'description' => '',
            'keywords' => [
                'Hackathon UFPR',
            ],
        ]));

        return view('homepage/hp_index', get_defined_vars());
    }
    
    # RELATORIO AVALIACAO DISCIPLINA
    public function relDisciplina(Request $request)
    {
        $seo = json_decode(json_encode([
            'title' => 'Relatório Avaliação de Disciplinas',
            'description' => '',
            'keywords' => [
                'Relatório Avaliação de Disciplinas',
            ],
        ]));

        return view('homepage/hp_rel_disciplina', get_defined_vars());
    }
    # RELATORIO AVALIACAO CURSO
    public function relCurso(Request $request)
    {
        $seo = json_decode(json_encode([
            'title' => 'Relatório Avaliação de Cursos',
            'description' => '',
            'keywords' => [
                'Relatório Avaliação de Cursos',
            ],
        ]));

        return view('homepage/hp_rel_curso', get_defined_vars());
    }
    # RELATORIO AVALIACAO INSTITUICAO
    public function relInstituicao(Request $request)
    {
        $seo = json_decode(json_encode([
            'title' => 'Relatório Avaliação Institucional',
            'description' => '',
            'keywords' => [
                'Relatório Avaliação Institucional',
            ],
        ]));

        return view('homepage/hp_rel_instituicao', get_defined_vars());
    }

    # PAINEL
    public function painel(Request $request)
    {
        $seo = json_decode(json_encode([
            'title' => 'Painel de Controle',
            'description' => '',
            'keywords' => [
                'Painel de Controle',
            ],
        ]));
        $user = auth()->user();

        return view('painel/p_index', get_defined_vars());
    }

    # ESTATISTICA ALERTA
    public function estatisticaAlerta(Request $request)
    {
        $seo = json_decode(json_encode([
            'title' => 'Relatório de Alertas',
            'description' => '',
            'keywords' => [
                'Relatório de Alertas',
            ],
        ]));
        $user = auth()->user();

        return view('painel/p_estatisticaAlerta', get_defined_vars());
    }

    # AVALIAÇÃO
    public function avaliacao(Request $request)
    {
        $seo = json_decode(json_encode([
            'title' => 'Avaliações',
            'description' => '',
            'keywords' => [
                'Avaliações',
            ],
        ]));
        $user = auth()->user();

        return view('painel/p_avaliacao', get_defined_vars());
    }

    # IMPORTAÇÃO PESQUISA
    public function importarPesquisa(Request $request)
    {
        $seo = json_decode(json_encode([
            'title' => 'Importação de Pesquisa',
            'description' => '',
            'keywords' => [
                'Importação de Pesquisa',
            ],
        ]));
        $user = auth()->user();

        $avaliacoes = Avaliacao::where('status_avaliacao', 'A')->orderBy('nome_avaliacao', 'ASC')->orderBy('ano_avaliacao', 'DESC')->get();

        return view('painel/p_importPesquisa', get_defined_vars());
    }

    # USUÁRIO
    public function usuario(Request $request)
    {
        $seo = json_decode(json_encode([
            'title' => 'Usuários',
            'description' => '',
            'keywords' => [
                'Usuários',
            ],
        ]));
        $user = auth()->user();

        return view('painel/p_usuario', get_defined_vars());
    }

    # TABELA GERAL
    public function tabelaGeral(Request $request)
    {
        $seo = json_decode(json_encode([
            'title' => 'Dados Gerais',
            'description' => '',
            'keywords' => [
                'Dados Gerais',
            ],
        ]));
        $user = auth()->user();

        return view('painel/p_tabelaGeral', get_defined_vars());
    }

}
