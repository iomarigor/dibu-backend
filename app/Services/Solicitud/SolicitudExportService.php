<?php

namespace App\Services\Solicitud;

use App\Exports\SolicitudesExport;
use Maatwebsite\Excel\Facades\Excel;

class SolicitudExportService
{
    public function export()/* : ?Model */
    {
        return Excel::download(new SolicitudesExport, 'users.xlsx');
    }
}
