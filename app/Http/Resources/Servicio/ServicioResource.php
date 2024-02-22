<?php

namespace App\Http\Resources\Servicio;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServicioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    
    public function toArray(Request $request)
    {
        return [
            'msg' => 'Servicio registrado satisfactoriamente',
            'detalle' => [
                'id' => $this->id,
                'descripcion' => $this->descripcion,
                'capacidad_maxima' => $this->capacidad_maxima,
            ]
        ];
        // return [
        //     'id'=> $this->id,
        //     'descripcion'=> $this->descripcion,
        //     'capacidad_maxima'=> $this->capacidad_maxima,
        // ];
    }
}