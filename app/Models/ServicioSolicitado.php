<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServicioSolicitado extends Model
{
    protected $connection = "mysql_dbu";
    protected $table = 'servicio_solicitado';
    protected $primaryKey = 'id';
    protected $fillable = [
        'estado',
        'servicio_id'
    ];
    public function status()
    {
        return $this->belongsTo(StatusData::class, 'status_id');
    }
    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class, 'solicitud_id');
    }
    public static function allDA()
    {
        return self::whereIn('status_id', [3, 2])->get();
    }

    public function servicio(): BelongsTo
    {
        return $this->belongsTo(Servicio::class);
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
