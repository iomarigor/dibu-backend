<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servicio extends Model
{
    protected $table = 'servicios';
    protected $primaryKey = 'id';

    protected $fillable = [
        'descripcion',
        'capacidad_maxima',
    ];
}