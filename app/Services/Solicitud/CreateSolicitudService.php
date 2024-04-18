<?php

namespace App\Services\Solicitud;

use App\Models\Alumno;
use App\Models\Convocatoria;
use App\Models\Requisito;
use App\Models\Solicitud;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateSolicitudService
{
    public function create(array $data)
    {
        /* $solicitud = Solicitud::where('convocatoria_id', $data['convocatoria_id'])
            ->where('alumno_id', $data['alumno_id'])
            ->delete(); */

        DB::beginTransaction();
        try {
            $solicitud = Solicitud::create([
                'convocatoria_id' => $data['convocatoria_id'],
                'alumno_id' => $data['alumno_id']
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
        $requisito = Requisito::where('id', $data["requisito_id"])->first();
        $alumno = Alumno::find($solicitud->alumno_id);
        if ($requisito->nombre == "Departamento de procedencia" || $requisito->nombre == "Provincia de procedencia" || $requisito->nombre == "Distrito de procedencia") {
            if (count(explode("/", $alumno->lugar_procedencia)) >= 4) $alumno->lugar_procedencia = "";
            $alumno->lugar_procedencia = $alumno->lugar_procedencia . strtoupper($data['respuesta_formulario']) . '/';
        }
        if ($requisito->nombre == "Departamento de nacimiento"  || $requisito->nombre == "Provincia de nacimiento" || $requisito->nombre == "Distrito de nacimiento") {
            if (count(explode("/", $alumno->lugar_nacimiento)) >= 4) $alumno->lugar_nacimiento = "";
            $alumno->lugar_nacimiento = $alumno->lugar_nacimiento . strtoupper($data['respuesta_formulario']) . '/';
        }
        $alumno->update();
        //recuperar el documento y almacenar en el storage
        return $solicitud->detalleSolicitudes()->create([
            "respuesta_formulario" => $data['respuesta_formulario'],
            "url_documento" => $data['url_documento'],
            "opcion_seleccion" => $data['opcion_seleccion'],
            'requisito_id' => $data['requisito_id'],
        ]);
    }


    private function saveFileLocal($file, $file_name)
    {
        //Decodificando Documento para ser guardado
        $filea = base64_decode($file);

        //Guardando Documento
        file_put_contents('storage/app/public/' . $file_name, $filea);
    }

    private function getUrlFile($file)
    {
        //Generando url del Documento almacenado
        return env('APP_URL') . '/storage/app/public/' . $file['id_convocatoria'] . '_' . $file['dni_alumno'] . '_' . $file['name_file'];
    }
}
