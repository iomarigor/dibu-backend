<?php

namespace App\Http\Resources\Requisito;

use Illuminate\Http\Resources\Json\JsonResource;

class RequisitoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'url_guia' => $this->url_guia,
            'estado' => $this->estado,
            'fecha_registro' => $this->fecha_registro,
            'tipo_requisito' => $this->tipo_requisito,
            'convocatoria_id' => $this->convocatoria_id,
            'seccion_id' => $this->seccion_id,
        ];
    }
}
