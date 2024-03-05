<?php

namespace App\Services\Convocatoria;

use App\Models\Convocatoria;
use Illuminate\Database\Eloquent\Model;

class ShowConvocatoriaService
{
    public function show($id): ?Model
    {
        $convocatoria = Convocatoria::find($id);
        return $convocatoria;
    }
}