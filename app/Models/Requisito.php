<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requisito extends Model
{
    protected $table = 'requisitos';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nombre',
        'descripcion',
        'url_guia',
        'estado',
        'fecha_registro',
        'tipo_requisito_id',
        'convocatoria_id',
        'seccion_id',
        'user_id',
    ];
    public function status()
    {
        return $this->belongsTo(StatusData::class, 'status_id');
    }

    public static function allDA()
    {
        return self::get();
    }


    public static function allall()
    {
        return self::all();
    }

    public static function findDA($id)
    {
        return self::whereIn('status_id', [2, 3])->find($id);
    }

    public function delete()
    {
        // Cambia el estado a "Eliminado" en lugar de eliminar el registro
        $this->status_id = 1;
        $this->save();
    }
}