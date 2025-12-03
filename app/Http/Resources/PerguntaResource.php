<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use App\Models\Avaliacao;
use App\Models\TabelaGeral;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PerguntaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                    => (string)$this->id,
            'DT_RowId'              => (string)$this->id,
            'id_avaliacao'          => Avaliacao::find($this->id_avaliacao),
            'id_questionario'       => $this->id_questionario,
            'categoria_pergunta'    => $this->categoria_pergunta,
            'ordem_pergunta'        => $this->ordem_pergunta,
            'tipo_pergunta'         => TabelaGeral::where("tipo_dado", "TIPO_PERGUNTA")->where("valor_dado", $this->tipo_pergunta)->first(),
            'texto_pergunta'        => $this->texto_pergunta,
            'created_at'            => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s'),
        ];
    }
}
