<?php

namespace App\Services\Solicitud;

use GuzzleHttp\Client;
use App\Exceptions\ExceptionGenerate;
use App\Models\Alumno;
use App\Models\DatosAlumnoAcademico;
use DateTime;

class ValidacionSolicitudService
{
    public function validate(array $data)
    {

        $faltas = $this->validateRequisitosSolicitud($data);
        if (count($faltas) > 0)
            throw new ExceptionGenerate('Usted con cumple con los siguiente requisitos para postular a los servicios de comedor e internado de la UNAS', 500, $faltas);
        //Registrando los datos de alumno apto para postulacion
        $datosAlumnoAcademico = $this->getDatosAlumnoAcademico($data['DNI']);

        $alumnoregistrado = Alumno::create([
            "codigo_estudiante" => $datosAlumnoAcademico['codalumno'],
            "DNI" => $data['DNI'],
            "nombres" => $datosAlumnoAcademico['nombre'],
            "apellido_paterno" => $datosAlumnoAcademico['appaterno'],
            "apellido_materno" => $datosAlumnoAcademico['apmaterno'],
            "sexo" => $datosAlumnoAcademico['sexo'],
            "facultad" => $datosAlumnoAcademico['nomfac'],
            "escuela_profesional" => $datosAlumnoAcademico['nomesp'],
            "modalidad_ingreso" => $datosAlumnoAcademico['mod_ingreso'],
            //"lugar_procedencia"=>$data['DNI'],
            //"lugar_nacimiento"=>$data['DNI'],
            "edad" => $this->getYearsInDates(new DateTime($datosAlumnoAcademico['fecnac']), new DateTime()),
            "correo_institucional" => $datosAlumnoAcademico['emailinst'],
            "direccion" => $datosAlumnoAcademico['direccion'],
            "fecha_nacimiento" => $datosAlumnoAcademico['fecnac'],
            "correo_personal" => $datosAlumnoAcademico['email'],
            "celular_estudiante" => $datosAlumnoAcademico['telcelular'],
            "celular_padre" => $datosAlumnoAcademico['tel_ref'],
        ]);
        return $alumnoregistrado;
    }
    private function validateRequisitosSolicitud(array $data)
    {
        $faltas = [];
        $consultaCaja = $this->consultaCaja($data['DNI']);
        if ($consultaCaja != null) {
            array_push($faltas, [
                "tipo" => "deudas",
                "msg" => "Usted mantiene una deuda por " . $consultaCaja->concepto_deuda . " monto:" . $consultaCaja->monto_deuda . " fecha:" . explode(" ", $consultaCaja->fecha_deuda)[0],
            ]);
        }
        //Validación de datos academicos
        $datosAlumnoAcademico = $this->getDatosAlumnoAcademico($data['DNI']);
        if ($datosAlumnoAcademico == null) {
            array_push($faltas,  [
                "tipo" => "academicos",
                "msg" => "No se encontraron registros de matricula",
            ]);
            return $faltas;
        }

        //Validar correo institucional
        if ($datosAlumnoAcademico['emailinst'] != $data['correo']) {
            array_push($faltas,  [
                "tipo" => "academicos",
                "msg" => "El correo electronico no coincide con el registrado en el sistema academico",
            ]);
        }

        //Validacion de promedio ponderado semestral aprovado
        if (floatval($datosAlumnoAcademico['pps']) < 10.50) {
            array_push($faltas,  [
                "tipo" => "academicos",
                "msg" => "No cumple con el promedio semestal minimo de 10.50, de usted es: " . $datosAlumnoAcademico['pps'],
            ]);
        }

        //Validacion de semestre matriculado
        if (strtoupper($datosAlumnoAcademico['est_mat_act']) == 'N') {
            array_push($faltas,  [
                "tipo" => "academicos",
                "msg" => "No se encuentra matriculado en el semeste actual",
            ]);
        }

        //Validación de numero de ciclos cursado
        if (intval($datosAlumnoAcademico['nume_sem_cur']) > 10) {
            array_push($faltas,  [
                "tipo" => "academicos",
                "msg" => "Ya no puede solicitar por exceso de semestre, de usted es: " . $datosAlumnoAcademico['nume_sem_cur'] . " el maximo se ciclos es 10",
            ]);
        }

        //Creditos matriculados (12 minimo)
        /* if (intval($datosAlumnoAcademico['nume_sem_cur']) <= 12) {
            array_push($faltas,  [
                "tipo" => "academicos",
                "msg" => "No cumple con los creditos minimos matriculas, de usted es: " . $datosAlumnoAcademico['nume_sem_cur'] . " el minimo es 12",
            ]);
        } */

        //Validar articulo incurso
        if (strlen($datosAlumnoAcademico['artincurso']) > 0) {
            array_push($faltas,  [
                "tipo" => "academicos",
                "msg" => "Usted no puede postular por que se encuentra incurso en los articulos " . $datosAlumnoAcademico['artincurso'],
            ]);
        }
        return $faltas;
    }
    private function consultaCaja(String $DNI)
    {
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => env('URL_CAJA_API'),
            // You can set any number of default request options.
            'timeout'  => 20.00,
        ]);
        $response  =  $client->request('GET', $DNI)->getBody()->getContents();
        $response = json_decode($response);
        return (count($response) >= 1) ? $response[0] : null;
    }
    private function getDatosAlumnoAcademico(String $DNI)
    {
        return DatosAlumnoAcademico::where('tdocumento', 'DNI' . $DNI)->first();
    }
    private function getYearsInDates(DateTime $firsData, DateTime $secondData)
    {
        $diferencia = $firsData->diff($secondData);
        return $diferencia->y;
    }
}
