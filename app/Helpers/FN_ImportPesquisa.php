<?php

use App\Models\Pergunta;
use App\Models\Avaliacao;
use App\Models\PesquisaCurso;
use App\Models\ImportPesquisa;
use App\Models\PesquisaDisciplina;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\PesquisaInstitucional;
use Illuminate\Support\Facades\Storage;

/**
 * Função para importação de dados de pesquisa
 * DISCIPLINA EAD
 * @param file   $arquivo
 * @param string $id_importacao
 * @param string $id_avaliacao
 * @param string $extensao
 * 
 * @return dados_importacao
*/
if(!function_exists("import_pesquisa_disciplina_ead"))
{
    function import_pesquisa_disciplina_ead($arquivo, $id_importacao, $id_avaliacao, $extensao)
    {

        $dados_arquivo = asset($arquivo);

        if (Storage::disk('local')->exists($arquivo)) {
            $dados_arquivo = Storage::disk('local')->get($arquivo);
        }

        $arrayImportacao = [];
        $countLinha = 0;
        $countPerguntas = 0;

        // Limpar dados antigos da avaliação
        PesquisaCurso::where('id_avaliacao', $id_avaliacao)->delete();

        $abas           = (new FastExcel)->withSheetsNames()->importSheets(Storage::path($arquivo));
        $abasArray      = $abas->toArray();
        $abaPerguntas   = $abasArray['Perguntas'];
        $abaPesquisa    = $abasArray['DadosPesquisa'];

        // Import Perguntas
        foreach ($abaPerguntas as $aPergunta) {
            if($aPergunta['ID_PERGUNTA'] == null){
                break;
            }
            else{
                $checkPergunta = Pergunta::where('id_avaliacao', $id_avaliacao)
                                        ->where('id_questionario', $aPergunta['ID_QUESTIONARIO'])
                                        ->where('categoria_pergunta', $aPergunta['CL_PERGUNTA'])
                                        ->where('ordem_pergunta', $aPergunta['Ordem'])
                                        ->where('tipo_pergunta', $aPergunta['Tipo_Pergunta'])
                                        ->first();
                if(is_null($checkPergunta)){
                    Pergunta::create([
                        'id_avaliacao'          => $id_avaliacao,
                        'id_questionario'       => $aPergunta['ID_QUESTIONARIO'],
                        'categoria_pergunta'    => $aPergunta['CL_PERGUNTA'],
                        'ordem_pergunta'        => $aPergunta['Ordem'],
                        'tipo_pergunta'         => $aPergunta['Tipo_Pergunta'],
                        'texto_pergunta'        => $aPergunta['PERGUNTA'],
                    ]);
                }
                else{
                    Pergunta::where('id', $checkPergunta->id)
                            ->update([
                                'ordem_pergunta'        => $aPergunta['Ordem'],
                                'tipo_pergunta'         => $aPergunta['Tipo_Pergunta'],
                                'texto_pergunta'        => $aPergunta['PERGUNTA'],
                            ]);
                }
                $countPerguntas++;
            }
        }

        // Import Dados Pesquisa
        foreach ($abaPesquisa as $aPesquisa) {
            PesquisaDisciplina::create([
                'id_avaliacao'      => $id_avaliacao,
                'id_pesquisa'       => $aPesquisa['ID_PESQUISA'],
                'id_questionario'   => $aPesquisa['ID_QUESTIONARIO'],
                'questionario'      => $aPesquisa['QUESTIONARIO'],
                'id_pergunta'       => $aPesquisa['ID_PERGUNTA'],
                'pergunta'          => $aPesquisa['PERGUNTA'],
                'resposta'          => $aPesquisa['RESPOSTA'],
                'situacao'          => $aPesquisa['SITUACAO'],
                'cod_disciplina'    => $aPesquisa['COD_DISCIPLINA'],
                'nome_disciplina'   => $aPesquisa['NOME_DISCIPLINA'],
                'multipla_escolha'  => $aPesquisa['MULTIPLA_ESCOLHA'],
                'modalidade'        => "EAD",
                'cod_curso'         => $aPesquisa['COD_CURSO'],
                'curso'             => $aPesquisa['CURSO'],
                'setor_curso'       => $aPesquisa['SETOR_CURSO'],
                'departamento'      => $aPesquisa['DEPARTAMENTO'],
                'codprof'           => $aPesquisa['CODPROF'],
            ]);
            $countLinha++;
        }

        $dados_importacao = [
            "total_linhas"      => $countLinha,
            "total_perguntas"   => $countPerguntas,
        ];

        $resultado_importacao = json_encode($dados_importacao);

        ImportPesquisa::where("id", $id_importacao)->update(["dados_importacao" => $resultado_importacao, "status_importacao" => "F"]);
        Avaliacao::where("id", $id_avaliacao)->update(["status_avaliacao" => "F"]);

        return $dados_importacao;
    }
}
/**
 * Função para importação de dados de pesquisa
 * DISCIPLINA PRESENCIAL
 * @param file   $arquivo
 * @param string $id_importacao
 * @param string $id_avaliacao
 * @param string $extensao
 * 
 * @return dados_importacao
*/
if(!function_exists("import_pesquisa_disciplina_presencial"))
{
    function import_pesquisa_disciplina_presencial($arquivo, $id_importacao, $id_avaliacao, $extensao)
    {
        $dados_arquivo = asset($arquivo);
        if (Storage::disk('local')->exists($arquivo)) {
            $dados_arquivo = Storage::disk('local')->get($arquivo);
        }

        $arrayImportacao = [];
        $countLinha = 0;
        $countPerguntas = 0;

        // Limpar dados antigos da avaliação
        PesquisaCurso::where('id_avaliacao', $id_avaliacao)->delete();

        $abas           = (new FastExcel)->withSheetsNames()->importSheets(Storage::path($arquivo));
        $abasArray      = $abas->toArray();
        $abaPerguntas   = $abasArray['Perguntas'];
        $abaPesquisa    = $abasArray['DadosPesquisa'];

        // Import Perguntas
        foreach ($abaPerguntas as $aPergunta) {
            if($aPergunta['ID_PERGUNTA'] == null){
                break;
            }
            else{
                $checkPergunta = Pergunta::where('id_avaliacao', $id_avaliacao)
                                        ->where('id_questionario', $aPergunta['ID_QUESTIONARIO'])
                                        ->where('categoria_pergunta', $aPergunta['CL_PERGUNTA'])
                                        ->where('ordem_pergunta', $aPergunta['Ordem'])
                                        ->where('tipo_pergunta', $aPergunta['Tipo_Pergunta'])
                                        ->first();
                if(is_null($checkPergunta)){
                    Pergunta::create([
                        'id_avaliacao'          => $id_avaliacao,
                        'id_questionario'       => $aPergunta['ID_QUESTIONARIO'],
                        'categoria_pergunta'    => $aPergunta['CL_PERGUNTA'],
                        'ordem_pergunta'        => $aPergunta['Ordem'],
                        'tipo_pergunta'         => $aPergunta['Tipo_Pergunta'],
                        'texto_pergunta'        => $aPergunta['PERGUNTA'],
                    ]);
                }
                else{
                    Pergunta::where('id', $checkPergunta->id)
                            ->update([
                                'ordem_pergunta'        => $aPergunta['Ordem'],
                                'tipo_pergunta'         => $aPergunta['Tipo_Pergunta'],
                                'texto_pergunta'        => $aPergunta['PERGUNTA'],
                            ]);
                }
                $countPerguntas++;
            }
        }

        // Import Dados Pesquisa
        foreach ($abaPesquisa as $aPesquisa) {
            PesquisaDisciplina::create([
                'id_avaliacao'      => $id_avaliacao,
                'id_pesquisa'       => $aPesquisa['ID_PESQUISA'],
                'id_questionario'   => $aPesquisa['ID_QUESTIONARIO'],
                'questionario'      => $aPesquisa['QUESTIONARIO'],
                'id_pergunta'       => $aPesquisa['ID_PERGUNTA'],
                'pergunta'          => $aPesquisa['PERGUNTA'],
                'resposta'          => $aPesquisa['RESPOSTA'],
                'situacao'          => $aPesquisa['SITUACAO'],
                'cod_disciplina'    => $aPesquisa['COD_DISCIPLINA'],
                'nome_disciplina'   => $aPesquisa['NOME_DISCIPLINA'],
                'multipla_escolha'  => $aPesquisa['MULTIPLA_ESCOLHA'],
                'modalidade'        => "PRESENCIAL",
                'cod_curso'         => $aPesquisa['COD_CURSO'],
                'curso'             => $aPesquisa['CURSO'],
                'setor_curso'       => $aPesquisa['SETOR_CURSO'],
                'departamento'      => $aPesquisa['DEPARTAMENTO'],
                'codprof'           => $aPesquisa['CODPROF'],
            ]);
            $countLinha++;
        }

        $dados_importacao = [
            "total_linhas"      => $countLinha,
            "total_perguntas"   => $countPerguntas,
        ];

        $resultado_importacao = json_encode($dados_importacao);

        ImportPesquisa::where("id", $id_importacao)->update(["dados_importacao" => $resultado_importacao, "status_importacao" => "F"]);
        Avaliacao::where("id", $id_avaliacao)->update(["status_avaliacao" => "F"]);

        return $dados_importacao;
    }
}
/**
 * Função para importação de dados de pesquisa
 * CURSO
 * @param file   $arquivo
 * @param string $id_importacao
 * @param string $id_avaliacao
 * @param string $extensao
 * 
 * @return dados_importacao
*/
if(!function_exists("import_pesquisa_curso"))
{
    function import_pesquisa_curso($arquivo, $id_importacao, $id_avaliacao, $extensao)
    {
        $dados_arquivo = asset($arquivo);
        if (Storage::disk('local')->exists($arquivo)) {
            $dados_arquivo = Storage::disk('local')->get($arquivo);
        }

        $arrayImportacao = [];
        $countLinha = 0;
        $countPerguntas = 0;

        // Limpar dados antigos da avaliação
        PesquisaCurso::where('id_avaliacao', $id_avaliacao)->delete();

        $abas           = (new FastExcel)->withSheetsNames()->importSheets(Storage::path($arquivo));
        $abasArray      = $abas->toArray();
        $abaPerguntas   = $abasArray['Perguntas'];
        $abaPesquisa    = $abasArray['DadosPesquisa'];

        // Import Perguntas
        foreach ($abaPerguntas as $aPergunta) {
            if($aPergunta['ID_PERGUNTA'] == null){
                break;
            }
            else{
                $checkPergunta = Pergunta::where('id_avaliacao', $id_avaliacao)
                                        ->where('id_questionario', $aPergunta['ID_QUESTIONARIO'])
                                        ->where('categoria_pergunta', $aPergunta['CL_PERGUNTA'])
                                        ->where('ordem_pergunta', $aPergunta['Ordem'])
                                        ->where('tipo_pergunta', $aPergunta['Tipo_Pergunta'])
                                        ->first();
                if(is_null($checkPergunta)){
                    Pergunta::create([
                        'id_avaliacao'          => $id_avaliacao,
                        'id_questionario'       => $aPergunta['ID_QUESTIONARIO'],
                        'categoria_pergunta'    => $aPergunta['CL_PERGUNTA'],
                        'ordem_pergunta'        => $aPergunta['Ordem'],
                        'tipo_pergunta'         => $aPergunta['Tipo_Pergunta'],
                        'texto_pergunta'        => $aPergunta['PERGUNTA'],
                    ]);
                }
                else{
                    Pergunta::where('id', $checkPergunta->id)
                            ->update([
                                'ordem_pergunta'        => $aPergunta['Ordem'],
                                'tipo_pergunta'         => $aPergunta['Tipo_Pergunta'],
                                'texto_pergunta'        => $aPergunta['PERGUNTA'],
                            ]);
                }
                $countPerguntas++;
            }
        }

        // Import Dados Pesquisa
        foreach ($abaPesquisa as $aPesquisa) {
            PesquisaCurso::create([
                'id_avaliacao'      => $id_avaliacao,
                'id_pesquisa'       => $aPesquisa['ID_PESQUISA'],
                'id_pergunta'       => $aPesquisa['ID_PERGUNTA'],
                'id_questionario'   => $aPesquisa['ID_QUESTIONARIO'],
                'questionario'      => $aPesquisa['QUESTIONARIO'],
                'pergunta'          => $aPesquisa['PERGUNTA'],
                'resposta'          => $aPesquisa['RESPOSTA'],
                'situacao'          => $aPesquisa['SITUACAO'],
                'multipla_escolha'  => $aPesquisa['MULTIPLA_ESCOLHA'],
                'curso'             => $aPesquisa['CURSO'],
                'cod_curso'         => $aPesquisa['COD_CURSO'],
                'setor_curso'       => $aPesquisa['SETOR_CURSO'],
            ]);
            $countLinha++;
        }

        $dados_importacao = [
            "total_linhas"      => $countLinha,
            "total_perguntas"   => $countPerguntas,
        ];

        $resultado_importacao = json_encode($dados_importacao);

        ImportPesquisa::where("id", $id_importacao)->update(["dados_importacao" => $resultado_importacao, "status_importacao" => "F"]);
        Avaliacao::where("id", $id_avaliacao)->update(["status_avaliacao" => "F"]);

        return $dados_importacao;
    }
}
/**
 * Função para importação de dados de pesquisa
 * INSTITUCIONAL
 * @param file   $arquivo
 * @param string $id_importacao
 * @param string $id_avaliacao
 * @param string $extensao
 * 
 * @return dados_importacao
*/
if(!function_exists("import_pesquisa_institucional"))
{
    function import_pesquisa_institucional($arquivo, $id_importacao, $id_avaliacao, $extensao)
    {
        $dados_arquivo = asset($arquivo);
        if (Storage::disk('local')->exists($arquivo)) {
            $dados_arquivo = Storage::disk('local')->get($arquivo);
        }

        $arrayImportacao = [];
        $countLinha = 0;
        $countPerguntas = 0;

        // Limpar dados antigos da avaliação
        PesquisaCurso::where('id_avaliacao', $id_avaliacao)->delete();

        $abas           = (new FastExcel)->withSheetsNames()->importSheets(Storage::path($arquivo));
        $abasArray      = $abas->toArray();
        $abaPerguntas   = $abasArray['Perguntas'];
        $abaPesquisa    = $abasArray['DadosPesquisa'];

        // Import Perguntas
        foreach ($abaPerguntas as $aPergunta) {
            if($aPergunta['ID_PERGUNTA'] == null){
                break;
            }
            else{
                $checkPergunta = Pergunta::where('id_avaliacao', $id_avaliacao)
                                        ->where('id_questionario', $aPergunta['ID_QUESTIONARIO'])
                                        ->where('categoria_pergunta', $aPergunta['CL_PERGUNTA'])
                                        ->where('ordem_pergunta', $aPergunta['Ordem'])
                                        ->where('tipo_pergunta', $aPergunta['Tipo_Pergunta'])
                                        ->first();
                if(is_null($checkPergunta)){
                    Pergunta::create([
                        'id_avaliacao'          => $id_avaliacao,
                        'id_questionario'       => $aPergunta['ID_QUESTIONARIO'],
                        'categoria_pergunta'    => $aPergunta['CL_PERGUNTA'],
                        'ordem_pergunta'        => $aPergunta['Ordem'],
                        'tipo_pergunta'         => $aPergunta['Tipo_Pergunta'],
                        'texto_pergunta'        => $aPergunta['PERGUNTA'],
                    ]);
                }
                else{
                    Pergunta::where('id', $checkPergunta->id)
                            ->update([
                                'ordem_pergunta'        => $aPergunta['Ordem'],
                                'tipo_pergunta'         => $aPergunta['Tipo_Pergunta'],
                                'texto_pergunta'        => $aPergunta['PERGUNTA'],
                            ]);
                }
                $countPerguntas++;
            }
        }

        // Import Dados Pesquisa
        foreach ($abaPesquisa as $aPesquisa) {
            PesquisaInstitucional::create([
                'id_avaliacao'      => $id_avaliacao,
                'id_pesquisa'       => $aPesquisa['ID_PESQUISA'],
                'id_questionario'   => $aPesquisa['ID_QUESTIONARIO'],
                'questionario'      => $aPesquisa['QUESTIONARIO'],
                'id_pergunta'       => $aPesquisa['ID_PERGUNTA'],
                'pergunta'          => $aPesquisa['PERGUNTA'],
                'resposta'          => $aPesquisa['RESPOSTA'],
                'situacao'          => $aPesquisa['SITUACAO'],
                'lotacao'           => $aPesquisa['LOTACAO'],
                'sigla_lotacao'     => $aPesquisa['SIGLA_LOTACAO'],
            ]);
            $countLinha++;
        }

        $dados_importacao = [
            "total_linhas"      => $countLinha,
            "total_perguntas"   => $countPerguntas,
        ];

        $resultado_importacao = json_encode($dados_importacao);

        ImportPesquisa::where("id", $id_importacao)->update(["dados_importacao" => $resultado_importacao, "status_importacao" => "F"]);
        Avaliacao::where("id", $id_avaliacao)->update(["status_avaliacao" => "F"]);

        return $dados_importacao;
    }
}