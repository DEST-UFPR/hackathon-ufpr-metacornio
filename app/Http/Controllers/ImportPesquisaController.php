<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\User;
use App\Models\Avaliacao;
use Illuminate\Http\Request;
use App\Models\ImportPesquisa;
use App\Jobs\ImportPesquisaJob;
use Illuminate\Validation\Rule;
use App\Http\Resources\ImportPesquisaResource;
use App\Http\Controllers\BaseController as BaseController;

class ImportPesquisaController extends BaseController
{
    /**
     * Pegar todos os registros
     */
    public function getAll()
    {
        $importPesquisa = ImportPesquisa::orderBy('created_at', 'ASC')->get();
        $message        = $importPesquisa->count() > 0 ? 'Listagem de Importações obtida com sucesso!' : 'Nenhuma Importação cadastrada.';

        return $this->sendSuccess(ImportPesquisaResource::collection($importPesquisa), $message);
    }

    /**
     * Gravar novo registro
     */
    public function newImportPesquisa(Request $request)
    {
        $regras = [
            'id_avaliacao'          => 'required',
            'arquivo_importacao'    => 'required|file',
        ];
        $mensagens = [
            'id_avaliacao.required'         => 'O campo Avaliação é obrigatório!',
            'arquivo_importacao.required'   => 'O campo Arquivo é obrigatório!',
        ];

        $validator = Validator::make($request->all(), $regras, $mensagens);
        if($validator->fails()){
            $returnValidator = [];
            $arValidator = json_decode($validator->errors()->toJson());
            foreach($arValidator as $k_valid => $v_valid ){
                $returnValidator[] = [
                    'campo'     => $k_valid,
                    'mensagem'  => $v_valid[0],
                ];
            }
            return $this->sendError('Preenchimento inválido dos campos', $returnValidator, 400);
        }

        $arquivo_importacao = $request->file('arquivo_importacao');
        $arquivo_nome       = strtok($arquivo_importacao->getClientOriginalName(), '.');
        if($arquivo_importacao->getClientMimeType() == "text/csv"){
            $arquivo_extensao = "csv";
        }
        else{
            $arquivo_extensao = $arquivo_importacao->extension();
        }
        $arquivo_upload     = $arquivo_nome .".". $arquivo_extensao;

        $upload = $arquivo_importacao->storeAs('importacao/pesquisa', $arquivo_upload);

        if($upload){
            $user = auth()->user();
            $dados_importacao = [
                "total_linhas"      => "0",
            ];
            $resultado_importacao = json_encode($dados_importacao);

            $input = $request->all();
            $dadosUpload = [
                "nome_usuario"          => $user->nome_usuario,
                "id_avaliacao"          => $input['id_avaliacao'],
                "caminho_arquivo"       => $upload,
                "nome_arquivo"          => $arquivo_upload,
                "dados_importacao"      => $dados_importacao,
                "status_importacao"     => "P",
            ];
            $importPesquisa = ImportPesquisa::create($dadosUpload);
        }
        else{
            return $this->sendError('Falha no carregamento do arquivo.', $upload, 400);
        }

        $dadosImportacao = [
            "id_importacao"         => $importPesquisa->id,
            "nome_usuario"          => $user->nome_usuario,
            "id_avaliacao"          => $importPesquisa->id_avaliacao,
            "caminho_arquivo"       => $upload,
            "nome_arquivo"          => $arquivo_upload,
        ];

        dispatch(new ImportPesquisaJob($dadosImportacao, $upload, $arquivo_extensao));
        return $this->sendSuccess(new ImportPesquisaResource($importPesquisa), 'Importação cadastrada com sucesso!');
    }

    /**
     * Pegar registro especifico
     */
    public function getImportPesquisa(Request $request)
    {
        $importPesquisa = ImportPesquisa::find($request->id);

        if(is_null($importPesquisa)){
            return $this->sendError('404', 'Registro não encontrado', 404);
        }

        return $this->sendSuccess(new ImportPesquisaResource($importPesquisa), 'Informações da Importação obtidas com sucesso!');
    }

    /**
     * Atualizar registro
     */
    public function updateImportPesquisa(Request $request)
    {
        $regras = [
            'nome_usuario'          => 'required',
            'nome_arquivo'          => 'required',
        ];
        $mensagens = [
            'nome_usuario.required'         => 'O campo Usuário é obrigatório!',
            'nome_arquivo.required'         => 'O campo Nome do Arquivo é obrigatório!',
        ];

        $validator = Validator::make($request->all(), $regras, $mensagens);
        if($validator->fails()){
            $returnValidator = [];
            $arValidator = json_decode($validator->errors()->toJson());
            foreach($arValidator as $k_valid => $v_valid ){
                $returnValidator[] = [
                    'campo'     => $k_valid,
                    'mensagem'  => $v_valid[0],
                ];
            }
            return $this->sendError('Preenchimento inválido dos campos', $returnValidator, 400);
        }

        $importPesquisa = ImportPesquisa::find($request->id);
        if(is_null($importPesquisa)){
            return $this->sendError('404', 'Registro não encontrado.', 404);
        }
        else{
            $input = $request->all();
            $importPesquisa->nome_usuario       = $input['nome_usuario'];
            $importPesquisa->nome_arquivo       = $input['nome_arquivo'];
            $importPesquisa->status_importacao  = $input['status_importacao'];
            $importPesquisa->save();

            return $this->sendSuccess(new ImportPesquisaResource($importPesquisa), 'Informações da Importação atualizadas com sucesso!');
        }
    }

    /**
     * Excluir registro
     */
    public function deleteImportPesquisa(Request $request)
    {
        if(!$request->id){
            return $this->sendError('400', 'Informações insuficientes para esta ação.', 400);
        }

        $importPesquisa = ImportPesquisa::find($request->id);
        if(is_null($importPesquisa)){
            return $this->sendError('404', 'Registro não encontrado.', 404);
        }
        else{
            $importPesquisa->delete();
            return $this->sendSuccess([], 'Registro da Importação excluído com sucesso!');
        }
    }

    /**
     * Pegar infos da Importação
     */
    public function getImportPesquisaCompleto(Request $request)
    {
        $importPesquisa = ImportPesquisa::find($request->id);
        if(is_null($importPesquisa)){
            return $this->sendError('404', 'Registro não encontrado.', 404);
        }
        else{
            $modalID      = "mVerImportacao";
            $modalHeader  = "Informações da Importação";

            $avaliacao  = Avaliacao::find($importPesquisa->id_avaliacao);
            $usuario    = User::where('nome_usuario', $importPesquisa->nome_usuario)->first();

            $returnHTML = view('components.modalImportacaoPesquisaCompleto')->with('modalInfo', [$modalID, $modalHeader, $importPesquisa, $avaliacao, $usuario])->render();
            return response()->json(array('success' => true, 'html' => $returnHTML), 200);
        }
    }

}
