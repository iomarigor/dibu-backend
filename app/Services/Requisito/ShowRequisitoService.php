<?php

namespace App\Services\Requisito;

use App\Http\Response\Response;
use App\Models\Requisito;
use Illuminate\Database\Eloquent\Model;

class ShowRequisitoService
{
    public function show($id): ?Model
    {
        $requisito = Requisito::find($id);
        return $requisito;
    }
}
