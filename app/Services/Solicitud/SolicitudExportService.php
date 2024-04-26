<?php

namespace App\Services\Solicitud;

use App\Models\Convocatoria;
use App\Exports\SolicitudesExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\Convocatoria\UltimaConvocatoriaService;

class SolicitudExportService
{
    public function export()/* : ?Model */
    {
        $convocatoria = Convocatoria::get();
        $convocatoria = $convocatoria[(count($convocatoria) - 1)];
        return Excel::download(new SolicitudesExport, $convocatoria->nombre . '-Solicitantes.xlsx');
    }
}
