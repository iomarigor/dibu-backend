<?php

namespace App\Services\Requisito;

use App\Models\Requisito;
use Illuminate\Database\Eloquent\Model;

class CreateRequisitoService
{
    public function create(array $data): Model
    {
        return Requisito::create([
            'descripcion' => $data['descripcion'],
            'capacidad_maxima' => $data['capacidad_maxima'],
        ]);
    }
}