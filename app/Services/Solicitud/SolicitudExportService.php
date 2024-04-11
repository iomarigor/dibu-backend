<?php

namespace App\Services\Solicitud;

use App\Exports\SolicitudesExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\Convocatoria\UltimaConvocatoriaService;

class SolicitudExportService
{
    public function export()/* : ?Model */
    {
        $ultimaC = new UltimaConvocatoriaService();
        $convocatoria = $ultimaC->vigente();
        return Excel::download(new SolicitudesExport, $convocatoria->nombre.'-Solicitantes.xlsx');
    }
}
