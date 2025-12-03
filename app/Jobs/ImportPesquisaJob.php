<?php

namespace App\Jobs;

use App\Models\Avaliacao;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ImportPesquisaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 1;
    public $timeout = 1200;
    public $dadosImportacao, $upload, $arquivo_extensao;

    /**
     * Create a new job instance.
     */
    public function __construct($dadosImportacao, $upload, $arquivo_extensao)
    {
        $this->dadosImportacao  = $dadosImportacao;
        $this->upload           = $upload;
        $this->arquivo_extensao = $arquivo_extensao;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $id_importacao      = $this->dadosImportacao['id_importacao'];
        $upload             = $this->dadosImportacao['caminho_arquivo'];
        $id_avaliacao       = $this->dadosImportacao['id_avaliacao'];

        $avaliacao          = Avaliacao::find($id_avaliacao);
        $categoria_pesquisa = $avaliacao->categoria_avaliacao;

        // Verificação de layout do arquivo
        switch ($categoria_pesquisa) {
            case 'EAD':
                $retornoImportacao = import_pesquisa_disciplina_ead($upload, $id_importacao, $id_avaliacao, $this->arquivo_extensao);
            break;
            case 'Presencial':
                $retornoImportacao = import_pesquisa_disciplina_presencial($upload, $id_importacao, $id_avaliacao, $this->arquivo_extensao);
            break;
            case 'Curso':
                $retornoImportacao = import_pesquisa_curso($upload, $id_importacao, $id_avaliacao, $this->arquivo_extensao);
            break;
            case 'Institucional':
                $retornoImportacao = import_pesquisa_institucional($upload, $id_importacao, $id_avaliacao, $this->arquivo_extensao);
            break;
        }

        return;
    }
}
