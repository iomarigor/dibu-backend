<?php

namespace App\Services\Requisito;

use App\Models\Requisito;
use Illuminate\Support\Collection;

class ListRequisitoService
{
    public function list(): Collection
    {
        return Servicio::all();
    }
}