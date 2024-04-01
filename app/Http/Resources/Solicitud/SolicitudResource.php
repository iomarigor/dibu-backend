<?php

namespace App\Http\Resources\Solicitud;

use App\Http\Resources\Alumno\AlumnoResource;
use App\Http\Resources\DetalleSolicitud\DetalleSolicitudResource;
use App\Http\Resources\ServicioSolicitado\ServicioSolicitadoResource;
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
            'fecha_solicitud' => $this->created_at->format('Y-m-d'),
            'convocatoria_id' => $this->convocatoria_id,
            'alumno' => AlumnoResource::make($this->alumno),
            'servicios_solicitados' => ServicioSolicitadoResource::collection($this->servicioSolicitados),
            'detalle_solicitudes' => $this->detalle_solicitudes/* DetalleSolicitudResource::collection($this->detalleSolicitudes, $this->convocatoria_id) */,
        ];
    }
}
