<?php

namespace App\Services\Convocatoria;

use App\Models\Convocatoria;
use App\Models\Seccion;
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

            foreach ($data['secciones'] as $seccionesData) {
                $this->secciones($seccionesData, $convocatoria);
            }
            DB::commit();

            $convocatoria->load(['secciones']);

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

    private function secciones(array $data, Convocatoria $convocatoria): Model
    {
        $secciones = $convocatoria->secciones()->create([
            'descripcion' => $data['descripcion'],
        ]);

        foreach ($data['requisitos'] as $requisitosData) {
            $this->requisitos($requisitosData, $secciones);
        }
        DB::commit();
        $secciones->load(['requisitos']);

        return $convocatoria;
    }

    private function requisitos(array $data, Seccion $secciones): Model
    {
        return $secciones->requisitos()->create([
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'],
            'url_guia' => $data['url_guia'],
            'url_plantilla' => $data['url_plantilla'],
            'opciones' => $data['opciones'],
            'tipo_requisito_id' => $data['tipo_requisito_id'],
            'user_id' => auth()->user()->id,
        ]);
    }
}
