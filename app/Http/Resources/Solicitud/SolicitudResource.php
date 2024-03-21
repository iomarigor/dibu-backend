<?php

namespace App\Http\Resources\Solicitud;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SolicitudResource extends JsonResource
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
            'fecha_solicitud' => $this->fecha_solicitud,
            'convocatoria_id' => $this->convocatoria_id,
            'alumno_id' => $this->alumno_id,
            'servicio_solicitado_id' => $this->servicio_solicitado_id,
        ];
    }
}