<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use App\Models\Avaliacao;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ImportPesquisaResource extends JsonResource
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
            'nome_usuario'          => $this->nome_usuario,
            'id_avaliacao'          => Avaliacao::find($this->id_avaliacao),
            'caminho_arquivo'       => $this->caminho_arquivo,
            'nome_arquivo'          => $this->nome_arquivo,
            'status_importacao'     => $this->status_importacao,
            'created_at'            => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s'),
        ];
    }
}
