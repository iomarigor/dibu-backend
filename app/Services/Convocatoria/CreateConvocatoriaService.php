<?php

namespace App\Services\Convocatoria;

use App\Models\Convocatoria;
use Illuminate\Database\Eloquent\Model;

class CreateConvocatoriaService
{
    public function create(array $data): Model
    {
        $user = auth()->user();
        return Convocatoria::create([
            'fecha_inicio' => $data['fecha_inicio'],
            'fecha_fin' => $data['fecha_fin'],
            'nombre' => $data['nombre'],
            'user_id' => $user->id,
        ]);
    }
}
