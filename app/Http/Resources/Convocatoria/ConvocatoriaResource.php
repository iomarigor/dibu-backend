<?php

namespace App\Http\Resources\Convocatoria;

use App\Http\Resources\Seccion\SeccionResource;
use App\Http\Resources\ConvocatoriaServicio\ConvocatoriaServicioResource;
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
            'estado' => $this->estado,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'convocatoria_servicio' => ConvocatoriaServicioResource::collection($this->convocatoriaServicio),
            'secciones' => SeccionResource::collection($this->secciones),
        ];
    }
}
