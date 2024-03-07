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
     * or
     * null
     */

    public function toArray(Request $request): ?array
    {
        //Verifica si el requisito es nulo
        if ($this->resource === null) {
            // Puedes devolver un arreglo vacío u algún valor predeterminado, según tus necesidades.
            return null;
        }
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'url_guia' => $this->url_guia,
            'tipo_requisito_id' => $this->tipo_requisito_id,
            'user_id' => $this->user_id,
            'fecha_registro' => $this->created_at->format('Y-m-d'),
        ];
    }
}
