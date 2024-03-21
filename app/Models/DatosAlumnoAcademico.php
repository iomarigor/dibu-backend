<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DatosAlumnoAcademico extends Model
{
    protected $connection = "connection_academico";
    protected $table = 'vdatos_alumnnos_obu';
    protected $primaryKey = 'codalumno';
    protected $fillable = [
        'codsem',
        'tdocumento',
        'appaterno',
        'apmaterno',
        'nombre',
        'sexo',
        'direccion',
        'fecnac',
        'mod_ingreso',
        'nombrecolegio',
        'ubigeo',
        'nomesp',
        'nomfac',
        'telcelular',
        'tel_ref',
        'email',
        'emailinst',
        'nume_sem_cur',
        'est_mat_act',
        'credmat',
        'pps',
        'ppa',
        'artincurso',
        'artpermanencia',
        'tca',
    ];
}
