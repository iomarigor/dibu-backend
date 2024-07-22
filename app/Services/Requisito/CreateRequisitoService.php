<?php

namespace App\Services\Requisito;

use App\Models\Requisito;
use Illuminate\Database\Eloquent\Model;

class CreateRequisitoService
{
    public function create(array $data): Model
    {
        $data['user_id'] = auth()->id();
        return Requisito::create($data);
    }
}
