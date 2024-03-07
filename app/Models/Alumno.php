<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $connection = "mysql_dbu";
    protected $table = 'alumnos';
    protected $primaryKey = 'id';
}
