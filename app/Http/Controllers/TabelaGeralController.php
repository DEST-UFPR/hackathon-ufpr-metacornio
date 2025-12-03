<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\TabelaGeral;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Resources\TabelaGeralResource;
use App\Http\Controllers\BaseController as BaseController;

class TabelaGeralController extends BaseController
{
    /**
     * Pegar todos os registros
     */
    public function getAll()
    {
        $tabelaGeral = TabelaGeral::orderBy('tipo_dado', 'ASC')->get();
        $message = $tabelaGeral->count() > 0 ? 'Listagem de Dados Gerais obtida com sucesso!' : 'Nenhum Dado Geral cadastrado.';

        return $this->sendSuccess(TabelaGeralResource::collection($tabelaGeral), $message);
    }

    /**
     * Gravar novo registro
     */
    public function newTabelaGeral(Request $request)
    {
        $regras = [
            'tipo_dado'      => 'required',
            'valor_dado'     => [
                'required',
                Rule::unique('tabela_geral')->where(function ($query) use ($request) {

                    return $query
                        ->whereTipoDado($request->tipo_dado)
                        ->whereValorDado($request->valor_dado);
                }),
            ],
            'descricao_dado'   => 'required',
            'sequencia'        => [
                'required',
                Rule::unique('tabela_geral')->where(function ($query) use ($request) {

                    return $query
                        ->whereTipoDado($request->tipo_dado)
                        ->whereSequencia($request->sequencia);
                }),
            ],
        ];
        $mensagens = [
            'tipo_dado.required'        => 'O campo Tipo de Dado é obrigatório!',
            'tipo_dado.unique'          => 'O Tipo de Dado informado já está em uso!',
            'valor_dado.required'       => 'O campo Valor do Dado é obrigatório!',
            'valor_dado.unique'         => 'O Valor do Dado informado já está em uso!',
            'descricao_dado.required'   => 'O campo Descrição do Dado é obrigatório!',
            'sequencia.required'        => 'O campo Sequência é obrigatório!',
            'sequencia.unique'          => 'A sequência informada já está em uso!',
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
        $input['tipo_dado']  = mb_strtoupper($input['tipo_dado'], "UTF-8");
        $input['valor_dado'] = mb_strtoupper($input['valor_dado'], "UTF-8");
        $tabelaGeral = TabelaGeral::create($input);

        return $this->sendSuccess(new TabelaGeralResource($tabelaGeral), 'Dado Geral cadastrado com sucesso!');
    } 

    /**
     * Pegar registro especifico
     */
    public function getTabelaGeral(Request $request)
    {
        $tabelaGeral = TabelaGeral::find($request->id);

        if (is_null($tabelaGeral)) {
            return $this->sendError('404', 'Registro Não Encontrado', 404);
        }

        return $this->sendSuccess(new TabelaGeralResource($tabelaGeral), 'Informações do Dado Geral obtidas com sucesso!');
    }
    
    /**
     * Atualizar registro
     */
    public function updateTabelaGeral(Request $request)
    {
        $regras = [
            'tipo_dado'      => 'required',
            'valor_dado'     => [
                'required',
                Rule::unique('tabela_geral')->where(function ($query) use ($request) {
                    return $query
                        ->whereTipoDado($request->tipo_dado)
                        ->whereValorDado($request->valor_dado)
                        ->whereNotIn('id', [$request->id]);
                }),
            ],
            'descricao_dado'   => 'required',
            'sequencia'     => [
                'required',
                Rule::unique('tabela_geral')->where(function ($query) use ($request) {
                    return $query
                        ->whereTipoDado($request->tipo_dado)
                        ->whereSequencia($request->sequencia)
                        ->whereNotIn('id', [$request->id]);
                }),
            ],
        ];
        $mensagens = [
            'tipo_dado.required'        => 'O campo Tipo de Dado é obrigatório!',
            'tipo_dado.unique'          => 'O Tipo de Dado informado já está em uso!',
            'valor_dado.required'       => 'O campo Valor do Dado é obrigatório!',
            'valor_dado.unique'         => 'O Valor do Dado informado já está em uso!',
            'descricao_dado.required'   => 'O campo Descrição do Dado é obrigatório!',
            'sequencia.required'        => 'O campo Sequência é obrigatório!',
            'sequencia.unique'          => 'A sequência informada já está em uso!',
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
        $tabelaGeral = TabelaGeral::find($request->id);
        $tabelaGeral->tipo_dado      = mb_strtoupper($input['tipo_dado'], "UTF-8");
        $tabelaGeral->valor_dado     = mb_strtoupper($input['valor_dado'], "UTF-8");
        $tabelaGeral->descricao_dado = $input['descricao_dado'];
        $tabelaGeral->sequencia      = $input['sequencia'];
        $tabelaGeral->save();

        return $this->sendSuccess(new TabelaGeralResource($tabelaGeral), 'Informações do Dado Geral atualizadas com sucesso!');
    }

    /**
     * Excluir registro
     */
    public function deleteTabelaGeral(Request $request)
    {
        if(!$request->id){
            return $this->sendError('400', 'Informações insuficientes para esta ação.', 400);
        }

        $tabelaGeral = TabelaGeral::find($request->id);
        if (is_null($tabelaGeral)) {
            return $this->sendError('404', 'Registro Não Encontrado', 404);
        }
        else{
            $tabelaGeral->delete();
            return $this->sendSuccess([], 'Registro do Dado Geral excluído com sucesso!');
        }
    }

    /**
     * Pegar infos da Tabela Geral Completo
     */
    public function getTabelaGeralCompleto(Request $request)
    {
        $dadosGerais = TabelaGeral::where("tipo_dado", $request->tipo_dado)->orderBy('sequencia', 'ASC')->get();
        $message = $dadosGerais->count() > 0 ? 'Listagem de Dados Gerais obtida com sucesso!' : 'Nenhum Dado Geral cadastrado.';

        return $this->sendSuccess(TabelaGeralResource::collection($dadosGerais), $message);
    }
}