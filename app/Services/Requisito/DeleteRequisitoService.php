<?php

namespace App\Services\Requisito;

use App\Http\Response\Response;
use App\Models\Requisito;
use Illuminate\Database\Eloquent\Model;

class DeleteRequisitoService
{
    public function delete($id): ?Model
    {
        $requisito = Requisito::find($id);
        if (!$requisito) {
            return null;
        }
        return $requisito->delete();
    }
}
