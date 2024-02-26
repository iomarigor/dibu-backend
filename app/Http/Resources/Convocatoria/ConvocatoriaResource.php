<?php

namespace App\Http\Resources\Convocatoria;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConvocatoriaResource extends JsonResource
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
            'nombre' => $this->nombre,
            'user_id' => $this->user_id,
            'servicio_id' => $this->servicio_id,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin
        ];
    }
}
