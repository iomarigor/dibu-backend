<?php

namespace App\Services\DatosAlumnoAcademico;

use App\Models\DatosAlumnoAcademico;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ListDatosAlumnoAcademico
{
    public function list(): Collection
    {

        return DatosAlumnoAcademico::all();
    }
}
