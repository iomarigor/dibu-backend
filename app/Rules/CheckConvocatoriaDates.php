<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Convocatoria;

class CheckConvocatoriaDates implements Rule
{
    public function passes($attribute, $value)
    {
        // Verificar que no haya convocatorias que se superpongan con la fecha proporcionada
        $convocatorias = Convocatoria::where(function ($query) use ($value) {
            $query->where('fecha_fin', '>=', $value);
        })->exists();

        return !$convocatorias;
    }

    public function message()
    {
        return 'No se puede crear la convocatoria durante una fecha establecida entre convocatorias existentes ni una que sea anterior a una convocatoria';
    }
}