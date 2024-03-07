<?php

namespace App\Services\Seccion;

use App\Models\Seccion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ListSeccionService
{
    public function list(): Collection
    {
        return Seccion::allDA();
    }
}
