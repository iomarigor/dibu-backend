<?php

namespace App\Services\Solicitud;

use App\Models\Solicitud;
use Illuminate\Database\Eloquent\Collection;

class ListSolicitudService
{
    public function list(): Collection
    {
        return Solicitud::all();
    }
}