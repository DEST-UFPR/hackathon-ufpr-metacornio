<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => (string)$this->id,
            'DT_RowId'          => (string)$this->id,
            'nome_usuario'      => $this->nome_usuario,
            'nome_completo'     => $this->nome_completo,
            'email_usuario'     => $this->email_usuario,
        ];
    }
}
