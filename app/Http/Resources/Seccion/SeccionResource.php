<?php

namespace App\Http\Resources\Seccion;

use App\Http\Resources\Requisito\RequisitoResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SeccionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'descripcion' => $this->descripcion,
            'requisitos' => RequisitoResource::collection($this->requisitos),
        ];
    }
}
