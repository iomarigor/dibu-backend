<?php

namespace App\Http\Resources\Requisito;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RequisitoResource extends JsonResource
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
            'descripcion' => $this->descripcion,
            'url_guia' => $this->url_guia,
            'estado' => $this->estado,
            'fecha_registro' => $this->fecha_registro,
            'tipo_requisito_id' => $this->tipo_requisito_id,
            'convocatoria_id' => $this->convocatoria_id,
            'seccion_id' => $this->seccion_id,
            'user_id' => $this->user_id,
        ];
    }
}
