<?php

namespace App\Http\Controllers;

use App\Http\Resources\DatosAlumnoAcademico\DatosAlumnoAcademicoResource;
use App\Http\Response\Response;
use App\Services\DatosAlumnoAcademico\ListDatosAlumnoAcademico;
use Laravel\Lumen\Routing\Controller;

class DatosAlumnoAcademicoController extends Controller
{
    //
    public function index(ListDatosAlumnoAcademico $listDatosAlumnoAcademico)
    {
        return Response::res('Datos academicos de alumnos', DatosAlumnoAcademicoResource::collection($listDatosAlumnoAcademico->list()), 200);
    }
}
