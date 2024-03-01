<?php

namespace App\Services\Requisito;

use App\Models\Requisito;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ListRequisitoService
{
    public function list(): Collection
    {
        return Requisito::allDA();
    }
}
