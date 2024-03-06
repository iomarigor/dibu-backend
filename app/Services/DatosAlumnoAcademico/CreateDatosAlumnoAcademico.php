<?php

namespace App\Services\DatosAlumnoAcademico;

use App\Models\DatosAlumnoAcademico;
use Illuminate\Database\Eloquent\Model;

class CreateDatosAlumnoAcademico
{
    public function create(array $data): Model
    {
        //$data['user_id'] = auth()->id();
        return DatosAlumnoAcademico::create($data);
    }
}
