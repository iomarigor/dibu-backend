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
                $this->detalleSolicitud($detalleSolicitudData, $solicitud);
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
    public function uploadFile(array $file): array
    {
        $file_name = $file['id_convocatoria'] . '_' . $file['dni_alumno'] . '_' . $file['name_file'];

        //Guardando Documento
        $this->saveFileLocal($file['file'], $file_name);

        $file['url_file'] = $this->getUrlFile($file);

        return $file;
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
        //recuperar el documento y almacenar en el storage
        return $solicitud->detalleSolicitudes()->create([
            "respuesta_formulario" => $data['respuesta_formulario'],
            "url_documento" => $data['url_documento'],
            'requisito_id' => $data['requisito_id'],
        ]);
    }


    private function saveFileLocal($file, $file_name)
    {
        //Decodificando Documento para ser guardado
        $filea = base64_decode($file);

        //Guardando Documento
        file_put_contents('../storage/app/public/' . $file_name, $filea);
    }

    private function getUrlFile($file)
    {
        //Generando url del Documento almacenado
        return env('APP_URL') . '/storage/app/public/' . $file['id_convocatoria'] . '_' . $file['dni_alumno'] . '_' . $file['name_file'];
    }
}
