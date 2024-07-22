<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleSolicitud extends Model
{
    protected $connection = "mysql_dbu";
    protected $table = 'detalle_solicitudes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'respuesta_formulario',
        'url_documento',
        'opcion_seleccion',
        'requisito_id'
    ];
    public function status()
    {
        return $this->belongsTo(StatusData::class, 'status_id');
    }

    public static function allDA()
    {
        return self::get();
    }
    public function requisito()
    {
        return $this->belongsTo(Requisito::class);
    }

    public static function allall()
    {
        return self::all();
    }

    public static function findDA($id)
    {
        return self::find($id);
    }

    public function delete()
    {
        // Cambia el estado a "Eliminado" en lugar de eliminar el registro
        $this->save();
    }
}
