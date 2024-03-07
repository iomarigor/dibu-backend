<?php

namespace App\Services\Convocatoria;

use App\Models\Convocatoria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateConvocatoriaService
{
    public function create(array $data): Model
    {
        DB::beginTransaction();
        $user = auth()->user();
        try {
            $convocatoria = Convocatoria::create([
                'fecha_inicio' => $data['fecha_inicio'],
                'fecha_fin' => $data['fecha_fin'],
                'nombre' => $data['nombre'],
                'user_id' => $user->id,
            ]);

            foreach ($data['convocatoria_servicio'] as $convocatoriaServicioData) {
                $this->convocatoriaServicio($convocatoriaServicioData, $convocatoria);
            }
            DB::commit();

            $convocatoria->load(['convocatoriaServicio']);

            return $convocatoria;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('convocatoria create: ' . $e->getMessage() . ', Line: ' . $e->getLine());
            throw $e;
        }
    }

    private function convocatoriaServicio(array $data, Convocatoria $convocatoria): Model
    {
        return $convocatoria->convocatoriaServicio()->create([
            'servicio_id' => $data['servicio_id'],
            'cantidad' => $data['cantidad'],
        ]);
    }
    // public function create(array $data): Model
    // {
    //     $user = auth()->user();
    //     return Convocatoria::create([
    //         'fecha_inicio' => $data['fecha_inicio'],
    //         'fecha_fin' => $data['fecha_fin'],
    //         'nombre' => $data['nombre'],
    //         'user_id' => $user->id,
    //     ]);
    // }
}
