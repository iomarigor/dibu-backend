<?php

namespace App\Exports;

use App\Models\Convocatoria;
use App\Models\DetalleSolicitud;
use App\Models\Requisito;
use App\Models\Servicio;
use App\Models\ServicioSolicitado;
use App\Models\Solicitud;
use App\Services\Convocatoria\UltimaConvocatoriaService;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SolicitudesExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    private array $demo = [
        'CODIGO',
        'FECHA',
        'DNI',
        'APELLIDOS Y NOMBRES',
        'SEXO',
        'FACULTAD',
        'ESCUELA PROFESIONAL',
        'ULT. SEM',
        'ESTADO MAT.',
        'CRED. MATRI.',
        'NUM. SEM. CURSADOS',
        'PPS',
        'PPA',
        'TCA',
        'F. NACIMIENTO',
        'EDAD',
        'LUG. NAC.',
        'L. PROCEDENCIA',
        'DIRECCIÓN',
        'TEL. PAPA',
        'TEL. EST.',
        'CORREO INST.',
        'MOD. INGRESO',
        'CORREO PERSONAL',
    ];

    public function collection()
    {
        $convocatoria = Convocatoria::find(1);
        //$convocatoria = $convocatoria[(count($convocatoria) - 1)];
        $solicitudesIDsTemporales = Solicitud::select(
            'solicitudes.id as id',
        )
            ->join('alumnos as a', 'solicitudes.alumno_id', '=', 'a.id')
            ->where('solicitudes.convocatoria_id', $convocatoria->id)
            ->orderBy('solicitudes.created_at', 'desc')
            ->get();

        $solicitudesTemporales = Solicitud::select(
            'a.codigo_estudiante',
            'solicitudes.created_at as fecha_solicitud',
            'a.DNI',
            DB::raw('concat(a.apellido_paterno, \' \', a.apellido_materno, \', \', a.nombres) as alumno'),
            'a.sexo',
            'a.facultad',
            'a.escuela_profesional',
            'a.ultimo_semestre',
            'a.estado_matricula',
            'a.creditos_matriculados',
            'a.num_semestres_cursados',
            'a.pps',
            'a.ppa',
            'a.tca',
            'a.fecha_nacimiento',
            'a.edad',
            'a.lugar_nacimiento',
            'a.lugar_procedencia',
            'a.direccion',
            'a.celular_padre',
            'a.celular_estudiante',
            'a.correo_institucional',
            'a.modalidad_ingreso',
            'a.correo_personal',
        )
            ->join('alumnos as a', 'solicitudes.alumno_id', '=', 'a.id')
            ->where('solicitudes.convocatoria_id', $convocatoria->id)
            ->orderBy('solicitudes.created_at', 'desc')
            ->where('a.correo_institucional', 'LIKE', "%lia.alania@unas.edu.pe%")
            ->orWhere('a.correo_institucional', 'LIKE', "%angel.taipe@unas.edu.pe%")
            ->orWhere('a.correo_institucional', 'LIKE', "%merilis.cierto@unas.edu.pe%")
            ->orWhere('a.correo_institucional', 'LIKE', "%mariciaelo.azañedo@unas.edu.pe%")
            ->orWhere('a.correo_institucional', 'LIKE', "%johan.archenti@unas.edu.pe%")
            ->orWhere('a.correo_institucional', 'LIKE', "%manuel.herrera@unas.edu.pe%")
            ->orWhere('a.correo_institucional', 'LIKE', "%banner.anteaga@unas.edu.pe%")
            ->orWhere('a.correo_institucional', 'LIKE', "%tony.soplin@unas.edu.pe%")
            ->orWhere('a.correo_institucional', 'LIKE', "%orlando.vallejos@unas.edu.pe%")
            ->orWhere('a.correo_institucional', 'LIKE', "%samuel.ascencio@unas.edu.pe%")
            ->orWhere('a.correo_institucional', 'LIKE', "%betkeila.antonio@unas.edu.pe%")
            ->orWhere('a.correo_institucional', 'LIKE', "%jheison.carranza@unas.edu.pe%")
            ->orWhere('a.correo_institucional', 'LIKE', "%flor.espiritu@unas.edu.pe%")
            ->orWhere('a.correo_institucional', 'LIKE', "%bridyith.valentin@unas.edu.pe%")
            ->orWhere('a.correo_institucional', 'LIKE', "%javier.nolazco@unas.edu.pe%")
            ->orWhere('a.correo_institucional', 'LIKE', "%matyori.sanchez@unas.edu.pe%")
            ->orWhere('a.correo_institucional', 'LIKE', "%alvaro.samaniego@unas.edu.pe%")
            ->orWhere('a.correo_institucional', 'LIKE', "%elvin.angulo@unas.edu.pe%")
            ->orWhere('a.correo_institucional', 'LIKE', "%daniela.gama@unas.edu.pe%")
            ->orWhere('a.correo_institucional', 'LIKE', "%ricky.malpartida@unas.edu.pe%")
            ->orWhere('a.correo_institucional', 'LIKE', "%gaudencia.dominguez@unas.edu.pe%")
            ->orWhere('a.correo_institucional', 'LIKE', "%diego.verde@unas.edu.pe%")
            ->orWhere('a.correo_institucional', 'LIKE', "%francisco.vidal@unas.edu.pe%")
            ->orWhere('a.correo_institucional', 'LIKE', "%bryam.gozme@unas.edu.pe%")
            ->orWhere('a.correo_institucional', 'LIKE', "%nayeli.seas@unas.edu.pe%")
            ->orWhere('a.correo_institucional', 'LIKE', "%mavila.carlos@unas.edu.pe%")
            ->orWhere('a.correo_institucional', 'LIKE', "%katrin.rios@unas.edu.pe%")
            ->orWhere('a.correo_institucional', 'LIKE', "%alvaro.castro@unas.edu.pe%")
            ->orWhere('a.correo_institucional', 'LIKE', "%liz.mamani@unas.edu.pe%")
            ->orWhere('a.correo_institucional', 'LIKE', "%esther.rodriguez@unas.edu.pe%")
            ->get();
        $solicitudesIDs = new Collection();
        $solicitudes = new Collection();

        for ($i = 0; $i < count($solicitudesTemporales); $i++) {
            if (!$solicitudes->contains('codigo_estudiante', $solicitudesTemporales[$i]->codigo_estudiante)) {
                $solicitudes->push($solicitudesTemporales[$i]);
                $solicitudesIDs->push($solicitudesIDsTemporales[$i]);
            }
        }
        for ($i = 0; $i < count($solicitudes); $i++) {
            //recorrer los requisitos de tipo 3
            $detalle_solicitud = DetalleSolicitud::select(
                'detalle_solicitudes.*',
            )
                ->join('solicitudes as s', 'detalle_solicitudes.solicitud_id', '=', 's.id')
                ->join('alumnos as a', 's.alumno_id', '=', 'a.id')
                ->where([
                    ['s.id', $solicitudesIDs[$i]->id],
                    ['s.convocatoria_id', $convocatoria->id]
                ])
                ->get();
            for ($j = 22; $j < count($detalle_solicitud); $j++) {
                $requisito = Requisito::select(
                    'tipo_requisito_id',
                    'id'
                )
                    ->where('id', $detalle_solicitud[$j]->requisito_id)->first();
                $dato = "";
                if ($requisito->tipo_requisito_id == 1 || $requisito->tipo_requisito_id == 2) {
                    $dato = $detalle_solicitud[$j]->url_documento;
                }
                if ($requisito->tipo_requisito_id == 3) {
                    $dato = $detalle_solicitud[$j]->respuesta_formulario;
                }
                if ($requisito->tipo_requisito_id == 4) {
                    $dato = $detalle_solicitud[$j]->opcion_seleccion;
                }
                $solicitudes[$i]->{$requisito->id} = $dato;
            }
            $servicios = Servicio::all();
            for ($k = 0; $k < count($servicios); $k++) {
                try {
                    $servicio_solicitado = ServicioSolicitado::select(
                        'servicio_solicitado.id',
                        'servicio_solicitado.estado'
                    )
                        ->join('solicitudes as s', 'servicio_solicitado.solicitud_id', '=', 's.id')
                        ->join('alumnos as a', 's.alumno_id', '=', 'a.id')
                        ->where([
                            ['servicio_solicitado.servicio_id', $servicios[$k]->id],
                            ['servicio_solicitado.solicitud_id', $solicitudesIDs[$i]->id]
                        ])
                        ->first();
                    $solicitudes[$i]->{"sv" . $servicio_solicitado->id} = $servicio_solicitado->estado;
                } catch (Exception $e) {
                    $solicitudes[$i]->{$i . '-' . $k} = '';
                }
            }
        }

        return $solicitudes;
    }

    public function headings(): array
    {
        $convocatoria = Convocatoria::first();
        $requisito = Requisito::select('requisitos.nombre')
            ->join('secciones as scc', 'requisitos.seccion_id', '=', 'scc.id')
            ->join('convocatorias as cv', 'scc.convocatoria_id', '=', 'cv.id')
            ->where('cv.id', $convocatoria->id)
            ->get();
        for ($i = 22; $i < count($requisito); $i++) {
            array_push($this->demo, strtoupper($requisito[$i]->nombre));
        }
        $servicios = Servicio::all();
        for ($i = 0; $i < count($servicios); $i++) {
            array_push($this->demo, strtoupper($servicios[$i]->nombre));
        }
        return $this->demo;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:L1'; // Rango de celdas
                $event->sheet->getStyle($cellRange)->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 16,
                        'color' => ['rgb' => 'FFFFFF'], // Color blanco
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '757575'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ]);
            },
        ];
    }
}
