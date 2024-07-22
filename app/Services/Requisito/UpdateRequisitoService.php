<?php

namespace App\Services\Requisito;

use App\Models\Requisito;
use Illuminate\Database\Eloquent\Model;

class UpdateRequisitoService
{
    public function update(array $data, $id): ?Model
    {
        $requisito = Requisito::where([
            ['id', '=', $id]
        ])->first();
        if (!$requisito)
            return null;
        $requisito->update($data);
        return $requisito;
    }
}
