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

    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'descripcion' => $this->descripcion,
            'capacidad_maxima' => $this->capacidad_maxima,
        ];
    }
}
