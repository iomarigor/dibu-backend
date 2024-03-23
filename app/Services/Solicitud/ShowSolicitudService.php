<?php

namespace App\Services\Solicitud;

use App\Models\Solicitud;
use Illuminate\Database\Eloquent\Model;

class ShowSolicitudService
{
    public function show($id): ?Model
    {
        $solicitud = Solicitud::find($id);
        return $solicitud;
    }
}