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