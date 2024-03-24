<?php

namespace App\Http\Resources\Alumno;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AlumnoValidacionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray(Request $request): array
    {
        return [
            'correo' => $this->correo,
            'DNI' => $this->DNI,
        ];
    }
}
