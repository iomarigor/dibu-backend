<?php

namespace App\Services\Servicio;

use App\Models\Servicio;
use Illuminate\Support\Collection;

class ListServicioService
{
    public function list(): Collection
    {
        return Servicio::all();
    }
}