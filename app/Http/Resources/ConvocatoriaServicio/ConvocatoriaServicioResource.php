<?php

namespace App\Http\Resources\ConvocatoriaServicio;

use App\Http\Resources\Servicio\ServicioResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConvocatoriaServicioResource extends JsonResource
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
            'servicio' => ServicioResource::make($this->servicio),
            'cantidad' => $this->cantidad,
        ];
    }
}
