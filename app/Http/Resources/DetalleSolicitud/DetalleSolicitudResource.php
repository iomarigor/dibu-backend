<?php

namespace App\Http\Resources\DetalleSolicitud;

use App\Http\Resources\Requisito\RequisitoResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetalleSolicitudResource extends JsonResource
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
            'respuesta_formulario' => $this->respuesta_formulario,
            'url_documento' => $this->url_documento,
            'requisito' => RequisitoResource::make($this->requisito),
        ];
    }
}