<?php

namespace App\Services\Solicitud;

use App\Exceptions\ExceptionGenerate;
use App\Models\Convocatoria;
use App\Models\ConvocatoriaServicio;
use App\Models\ServicioSolicitado;
use App\Models\Solicitud;
use App\Services\Convocatoria\UltimaConvocatoriaService;
use DateTime;
use Illuminate\Database\Eloquent\Collection;

class SolicitudServicioService
{
    public function updateServicio(array $data): ?Collection
    {
        //dd($data);
        $servicioIds = array_column($data['servicios'], 'servicio_id');
        foreach ($data['servicios'] as $key => $value) {
            if ($value['estado'] != 'pendiente' && $value['estado'] != 'rechazado' && $value['estado'] != 'aceptado' && $value['estado'] != 'aprobado')
                throw new ExceptionGenerate('El estado de quiere actualizar no existe', 200);
            if ($value['estado'] == 'aprobado') {
                //obtener la convocatoria actual
                $fechaActual = new DateTime();
                $convocatoria = Convocatoria::whereDate('fecha_inicio', '<=', $fechaActual)
                    ->whereDate('fecha_fin', '>=', $fechaActual)->first();
                if (!$convocatoria)
                    throw new ExceptionGenerate('Actualmente no existe convocatoria en curso', 200);

                //listar los servicios de la convocatoria para la obtencion de la cantidad
                $servicios = ConvocatoriaServicio::where([['convocatoria_id', $convocatoria->id], ['servicio_id', $value['servicio_id']]])->first();

                //obtener el total de las solicitudes registradas con estado aprobado y validar la cantidad
                $numeroSolicitudesServicioPorConvocatoria = ServicioSolicitado::whereHas('solicitud', function ($query) use ($convocatoria, $value) {
                    $query->where('convocatoria_id', $convocatoria->id)
                        ->where('servicio_id', $value['servicio_id']);
                })
                    ->where('estado', 'aprobado')
                    ->count();
                //validar que la cantidad sea menor a la cantidad de servicios de la convocatoria
                if (intval($numeroSolicitudesServicioPorConvocatoria) > intval($servicios->cantidad))
                    throw new ExceptionGenerate('Ya no existen vacantes para aceptar la solicitud para el servicio ' . $servicios->id, 200);
            }
            $solicitud = ServicioSolicitado::where('solicitud_id', $data['solicitud_id'])->find($value['servicio_id']);
            $solicitud->estado = $value['estado'];
            if ($value['estado'] == 'rechazado') $solicitud->detalle_rechazo = $value['detalle_rechazo'];
            $solicitud->save();
        }
        return ServicioSolicitado::whereIn('id', $servicioIds)->get();
    }
}
