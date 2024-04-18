<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requisito extends Model
{
    protected $connection = "mysql_dbu";
    protected $table = 'requisitos';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nombre',
        'descripcion',
        'url_guia',
        'url_plantilla',
        'opciones',
        'tipo_requisito_id',
        'seccion_id',
        'user_id',
    ];
    public static function allDA()
    {
        return self::get();
    }

    public function seccion()
    {
        return $this->belongsTo(Seccion::class);
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
