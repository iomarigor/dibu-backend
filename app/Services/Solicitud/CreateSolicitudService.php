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
        try {
            $solicitud = Solicitud::create([
                'convocatoria_id' => $data['convocatoria_id'],
                'alumno_id' => $data['alumno_id'],
            ]);

            foreach ($data['servicios_solicitados'] as $servicioSolicitadoData) {
                $this->servicioSolicitado($servicioSolicitadoData, $solicitud);
            }
            DB::commit();

            $solicitud->load(['servicioSolicitados']);
            
            foreach ($data['detalle_solicitudes'] as $detalleSolicitudData) {
                if($detalleSolicitudData['requisito_id'] <= count($detalleSolicitudData)){
                    $this->detalleSolicitud($detalleSolicitudData, $solicitud);
                }
            }
            DB::commit();

            $solicitud->load(['detalleSolicitudes']);

            return $solicitud;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('solicitud create: ' . $e->getMessage() . ', Line: ' . $e->getLine());
            throw $e;
        }
    }
    
    private function servicioSolicitado(array $data, Solicitud $solicitud): Model
    {
        return $solicitud->servicioSolicitados()->create([
            'estado' => $data['estado'],
            'servicio_id' => $data['servicio_id'],
        ]);
    }
    
    private function detalleSolicitud(array $data, Solicitud $solicitud): Model
    {
        return $solicitud->detalleSolicitudes()->create([
            "respuesta_formulario" => $data['respuesta_formulario'],
            "url_documento" => $data['url_documento'],
            'requisito_id' => $data['requisito_id'],
        ]);
    }
}
