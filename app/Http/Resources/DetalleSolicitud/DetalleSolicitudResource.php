<?php

namespace App\Http\Resources\DetalleSolicitud;

use App\Http\Resources\Requisito\RequisitoResource;
use App\Models\DetalleSolicitud;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetalleSolicitudResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray(Request $request)/* : array */
    {
        return DetalleSolicitud::with('requisito.seccion')
            ->where('solicitud_id', $this->id)
            ->get()
            ->groupBy(function (DetalleSolicitud $detalle_solicitud) {
                return $detalle_solicitud->requisito->seccion_id;
            });
    }
}
