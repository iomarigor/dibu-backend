<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LevelUser extends Model
{
    protected $table = 'level_user'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'id'; // Clave primaria de la tabla
    public $timestamps = true; // Si deseas habilitar campos de fecha created_at y updated_at

    protected $fillable = ['description']; // Lista de atributos que se pueden asignar en masa

}
