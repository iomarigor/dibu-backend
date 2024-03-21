<?php

namespace App\Services\Solicitud;

use App\Models\Solicitud;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateSolicitudService
{
    public function create(array $data): Model
    {
        DB::beginTransaction();
        $user = auth()->user();
        try {
            $solicitud = Solicitud::create([
                'fecha_inicio' => $data['fecha_inicio'],
                'fecha_fin' => $data['fecha_fin'],
                'nombre' => $data['nombre'],
                'user_id' => $user->id,
            ]);

            return $solicitud;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('solicitud create: ' . $e->getMessage() . ', Line: ' . $e->getLine());
            throw $e;
        }
    }
}
