<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    protected $table = 'items'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'id'; // Clave primaria de la tabla

    protected $fillable = [
        'id_types_item',
        'id_status_item',
        'image',
        'code',
        'heritage',
        'name',
        'brand',
        'cpu',
        'processor',
        'color',
        'ram',
        'disc',
        'generation',
        'model',
        'model_number',
        'in_charge',
        'n_serial',
        'location',
        'observation',
        'type',
        'os_type',
        'series_dimensions',
        'last_user',
        'status_id',
    ];

    public function typeItem()
    {
        return $this->belongsTo(TypesItem::class, 'id_types_item');
    }

    public function statusItem()
    {
        return $this->belongsTo(StatusItem::class, 'id_status_item');
    }

    public function lastUser()
    {
        return $this->belongsTo(User::class, 'last_user');
    }

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
