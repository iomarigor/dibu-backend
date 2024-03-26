<?php

namespace App\Http\Resources\ServicioSolicitado;

use App\Http\Resources\Servicio\ServicioResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServicioSolicitadoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'estado' => $this->estado,
            'servicio_id' => $this->servicio_id,
            'solicitud_id' => $this->solicitud_id,
            'servicio' => ServicioResource::make($this->servicio),
        ];
    }
}
