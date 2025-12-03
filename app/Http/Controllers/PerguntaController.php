<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Pergunta;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Resources\PerguntaResource;
use App\Http\Controllers\BaseController as BaseController;

class PerguntaController extends BaseController
{
    /**
     * Pegar todos os registros
     */
    public function getAll()
    {
        $pergunta = Pergunta::orderBy('id_avaliacao', 'ASC')->orderBy('id_questionario', 'ASC')->orderBy('ordem_pergunta', 'ASC')->get();
        $message = $pergunta->count() > 0 ? 'Listagem de Perguntas obtida com sucesso!' : 'Nenhuma Pergunta cadastrada.';

        return $this->sendSuccess(PerguntaResource::collection($pergunta), $message);
    }

    /**
     * Gravar novo registro
     */
    public function newPergunta(Request $request)
    {
        $regras = [
            'id_avaliacao'          => 'required',
            'id_questionario'       => 'required',
            'categoria_pergunta'    => 'required',
            'ordem_pergunta'        => 'required',
            'tipo_pergunta'         => 'required',
            'texto_pergunta'        => 'required',
        ];
        $mensagens = [
            'id_avaliacao.required'          => 'O campo Avaliação é obrigatório!',
            'id_questionario.required'       => 'O campo Questionário é obrigatório!',
            'categoria_pergunta.required'    => 'O campo Categoria Pergunta é obrigatório!',
            'ordem_pergunta.required'        => 'O campo Ordem Pergunta é obrigatório!',
            'tipo_pergunta.required'         => 'O campo Tipo Pergunta é obrigatório!',
            'texto_pergunta.required'        => 'O campo Texto Pergunta é obrigatório!',
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
        $pergunta = Pergunta::create($input);

        return $this->sendSuccess(new PerguntaResource($pergunta), 'Pergunta cadastrada com sucesso!');
    }

    /**
     * Pegar registro especifico
     */
    public function getPergunta(Request $request)
    {
        $pergunta = Pergunta::find($request->id);

        if(is_null($pergunta)){
            return $this->sendError('404', 'Registro não encontrado', 404);
        }

        return $this->sendSuccess(new PerguntaResource($pergunta), 'Informações da Pergunta obtidas com sucesso!');
    }

    /**
     * Atualizar registro
     */
    public function updatePergunta(Request $request)
    {
        $regras = [
            'id_avaliacao'          => 'required',
            'id_questionario'       => 'required',
            'categoria_pergunta'    => 'required',
            'ordem_pergunta'        => 'required',
            'tipo_pergunta'         => 'required',
            'texto_pergunta'        => 'required',
        ];
        $mensagens = [
            'id_avaliacao.required'          => 'O campo Avaliação é obrigatório!',
            'id_questionario.required'       => 'O campo Questionário é obrigatório!',
            'categoria_pergunta.required'    => 'O campo Categoria Pergunta é obrigatório!',
            'ordem_pergunta.required'        => 'O campo Ordem Pergunta é obrigatório!',
            'tipo_pergunta.required'         => 'O campo Tipo Pergunta é obrigatório!',
            'texto_pergunta.required'        => 'O campo Texto Pergunta é obrigatório!',
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

        $pergunta = Pergunta::find($request->id);
        if(is_null($pergunta)){
            return $this->sendError('404', 'Registro não encontrado.', 404);
        }
        else{
            $pergunta->id_avaliacao        = $request->id_avaliacao;
            $pergunta->id_questionario     = $request->id_questionario;
            $pergunta->categoria_pergunta  = $request->categoria_pergunta;
            $pergunta->ordem_pergunta      = $request->ordem_pergunta;
            $pergunta->tipo_pergunta       = $request->tipo_pergunta;
            $pergunta->texto_pergunta      = $request->texto_pergunta;
            $pergunta->save();

            return $this->sendSuccess(new PerguntaResource($pergunta), 'Informações da Pergunta atualizadas com sucesso!');
        }
    }

    /**
     * Excluir registro
     */
    public function deletePergunta(Request $request)
    {
        if(!$request->id){
            return $this->sendError('400', 'Informações insuficientes para esta ação.', 400);
        }

        $pergunta = Pergunta::find($request->id);
        if(is_null($pergunta)){
            return $this->sendError('404', 'Registro não encontrado.', 404);
        }
        else{
            $pergunta->delete();
            return $this->sendSuccess([], 'Registro da Pergunta excluído com sucesso!');
        }
    }

    /**
     * Pegar infos da Pergunta
     */
    public function getPerguntaCompleto(Request $request)
    {
        $pergunta = Pergunta::find($request->id);
        if(is_null($pergunta)){
            return $this->sendError('404', 'Registro não encontrado.', 404);
        }
        else{
            $modalID      = "mVerPergunta";
            $modalHeader  = "Informações da Pergunta";

            $returnHTML = view('components.modalPerguntaCompleto')->with('modalInfo', [$modalID, $modalHeader, $pergunta])->render();
            return response()->json(array('success' => true, 'html' => $returnHTML), 200);
        }
    }

}
