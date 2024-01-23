<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusData extends Model
{
    protected $table = 'status_data'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'id'; // Clave primaria de la tabla
    public $timestamps = true; // Si tienes campos de fecha created_at y updated_at
    protected $fillable = ['description']; // Campos que pueden ser llenados masivamente
}
