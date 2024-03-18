<?php

namespace App\Services\Convocatoria;

use App\Models\Convocatoria;
use Illuminate\Database\Eloquent\Model;

class UltimaConvocatoriaService
{
    public function ultima(): ?Model
    {
        return Convocatoria::latest()->first();
    }
}