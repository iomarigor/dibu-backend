<?php

namespace App\Services\Convocatoria;

use App\Models\Convocatoria;
use Illuminate\Database\Eloquent\Model;

class CreateConvocatoriaService
{
    public function create(array $data): Model
    {
        return Convocatoria::create([
            'name' => $data['name'],
        ]);
    }
}