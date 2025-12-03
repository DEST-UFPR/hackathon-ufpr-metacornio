<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TabelaGeralResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                    => (string)$this->id,
            'DT_RowId'              => (string)$this->id,
            'tipo_dado'             => $this->tipo_dado,
            'valor_dado'            => $this->valor_dado,
            'descricao_dado'        => $this->descricao_dado,
            'sequencia'             => $this->sequencia,
            'created_at'            => $this->created_at,
            'updated_at'            => $this->updated_at,
        ];
    }
}
