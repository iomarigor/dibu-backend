<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusData extends Model
{
    protected $table = 'status_data'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'id'; // Clave primaria de la tabla
    public $timestamps = true; // Si tienes campos de fecha created_at y updated_at
    protected $fillable = ['description']; // Campos que pueden ser llenados masivamente
    public function status()
    {
        return $this->belongsTo(StatusData::class, 'status_id');
    }

    public static function allDA()
    {
        return self::whereIn('status_id', [3, 2])->get();
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
