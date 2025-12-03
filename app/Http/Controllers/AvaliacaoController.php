<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Pergunta;
use App\Models\Avaliacao;
use Illuminate\Http\Request;
use App\Models\ImportPesquisa;
use Illuminate\Validation\Rule;
use App\Http\Resources\AvaliacaoResource;
use App\Http\Controllers\BaseController as BaseController;

class AvaliacaoController extends BaseController
{
    /**
     * Pegar todos os registros
     */
    public function getAll()
    {
        $avaliacao = Avaliacao::orderBy('nome_avaliacao', 'ASC')->orderBy('ano_avaliacao', 'DESC')->get();
        $message = $avaliacao->count() > 0 ? 'Listagem de Avaliações obtida com sucesso!' : 'Nenhuma Avaliação cadastrada.';

        return $this->sendSuccess(AvaliacaoResource::collection($avaliacao), $message);
    }

    /**
     * Gravar novo registro
     */
    public function newAvaliacao(Request $request)
    {
        $regras = [
            'nome_avaliacao'      => 'required',
            'categoria_avaliacao' => 'required',
            'ano_avaliacao'       => 'required',
            'status_avaliacao'    => 'required',
        ];
        $mensagens = [
            'nome_avaliacao.required'       => 'O campo Nome é obrigatório!',
            'categoria_avaliacao.required'  => 'O campo Categoria é obrigatório!',
            'ano_avaliacao.required'        => 'O campo Ano é obrigatório!',
            'status_avaliacao.required'     => 'O campo Status é obrigatório!',
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

        $input = $request->all();
        if(isset($request->semestre_avaliacao)){
            $input['periodo_label'] = $request->ano_avaliacao . " / " . $request->semestre_avaliacao;
        }
        else{
            $input['periodo_label'] = $request->ano_avaliacao;
        }
        $avaliacao = Avaliacao::create($input);

        return $this->sendSuccess(new AvaliacaoResource($avaliacao), 'Avaliação cadastrada com sucesso!');
    }

    /**
     * Pegar registro especifico
     */
    public function getAvaliacao(Request $request)
    {
        $avaliacao = Avaliacao::find($request->id);

        if(is_null($avaliacao)){
            return $this->sendError('404', 'Registro não encontrado', 404);
        }

        return $this->sendSuccess(new AvaliacaoResource($avaliacao), 'Informações da Avaliação obtidas com sucesso!');
    }

    /**
     * Atualizar registro
     */
    public function updateAvaliacao(Request $request)
    {
        $regras = [
            'nome_avaliacao'      => 'required',
            'categoria_avaliacao' => [
                'required',
                Rule::unique('avaliacao')->where(function ($query) use ($request) {
                    return $query
                        ->whereCategoriaAvaliacao($request->categoria_avaliacao)
                        ->whereAnoAvaliacao($request->ano_avaliacao)
                        ->whereNotIn('id', [$request->id]);
                }),
            ],
            'ano_avaliacao'       => 'required',
            'status_avaliacao'    => 'required',
        ];
        $mensagens = [
            'nome_avaliacao.required'       => 'O campo Nome é obrigatório!',
            'categoria_avaliacao.required'  => 'O campo Categoria é obrigatório!',
            'categoria_avaliacao.unique'    => 'Já existe uma Avaliação cadastrada com esta Categoria e Ano!',
            'ano_avaliacao.required'        => 'O campo Ano é obrigatório!',
            'status_avaliacao.required'     => 'O campo Status é obrigatório!',
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

        $avaliacao = Avaliacao::find($request->id);
        if(is_null($avaliacao)){
            return $this->sendError('404', 'Registro não encontrado.', 404);
        }
        else{
            $avaliacao->nome_avaliacao      = $request->nome_avaliacao;
            $avaliacao->categoria_avaliacao = $request->categoria_avaliacao;
            $avaliacao->semestre_avaliacao  = $request->semestre_avaliacao;
            $avaliacao->ano_avaliacao       = $request->ano_avaliacao;
            if(isset($request->semestre_avaliacao)){
            $avaliacao->periodo_label = $request->ano_avaliacao . " / " . $request->semestre_avaliacao;
            }
            else{
                $avaliacao->periodo_label = $request->ano_avaliacao;
            }
            $avaliacao->status_avaliacao    = $request->status_avaliacao;
            $avaliacao->save();

            return $this->sendSuccess(new AvaliacaoResource($avaliacao), 'Informações da Avaliação atualizadas com sucesso!');
        }
    }

    /**
     * Excluir registro
     */
    public function deleteAvaliacao(Request $request)
    {
        if(!$request->id){
            return $this->sendError('400', 'Informações insuficientes para esta ação.', 400);
        }

        $avaliacao = Avaliacao::find($request->id);
        if(is_null($avaliacao)){
            return $this->sendError('404', 'Registro não encontrado.', 404);
        }
        else{
            $avaliacao->delete();
            return $this->sendSuccess([], 'Registro da Avaliação excluído com sucesso!');
        }
    }

    /**
     * Pegar infos da Avaliação
     */
    public function getAvaliacaoCompleto(Request $request)
    {
        $avaliacao = Avaliacao::find($request->id);
        if(is_null($avaliacao)){
            return $this->sendError('404', 'Registro não encontrado.', 404);
        }
        else{
            $modalID      = "mVerAvaliacao";
            $modalHeader  = "Informações da Avaliação";

            $pergunta       = Pergunta::where('id_avaliacao', $avaliacao->id)->orderBy("categoria_pergunta")->orderBy("ordem_pergunta")->get();
            $importPesquisa = ImportPesquisa::where('id_avaliacao', $avaliacao->id)->get();

            $returnHTML = view('components.modalAvaliacaoCompleto')->with('modalInfo', [$modalID, $modalHeader, $avaliacao, $pergunta, $importPesquisa])->render();
            return response()->json(array('success' => true, 'html' => $returnHTML), 200);
        }
    }

}
