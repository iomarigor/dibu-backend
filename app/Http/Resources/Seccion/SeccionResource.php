<?php

namespace App\Http\Resources\Seccion;

use Illuminate\Http\Resources\Json\JsonResource;

class SeccionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'descripcion' => $this->descripcion,
            'convocatoria_id' => $this->convocatoria_id,
        ];
    }
}
