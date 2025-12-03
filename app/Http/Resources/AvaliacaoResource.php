<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AvaliacaoResource extends JsonResource
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
            'nome_avaliacao'        => $this->nome_avaliacao,
            'categoria_avaliacao'   => $this->categoria_avaliacao,
            'semestre_avaliacao'    => $this->semestre_avaliacao,
            'ano_avaliacao'         => $this->ano_avaliacao,
            'periodo_label'         => $this->periodo_label,
            'status_avaliacao'      => $this->status_avaliacao,
            'created_at'            => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s'),
        ];
    }
}
