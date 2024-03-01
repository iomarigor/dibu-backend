<?php

namespace App\Services\Convocatoria;

use App\Models\Convocatoria;
use Illuminate\Support\Collection;

class ListConvocatoriaService
{
    public function list(): Collection
    {
        return Convocatoria::all();
    }
}