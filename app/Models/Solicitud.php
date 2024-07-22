<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Solicitud extends Model
{
    protected $connection = "mysql_dbu";
    protected $table = 'solicitudes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'convocatoria_id',
        'alumno_id',
        'solicitud_id',
        'created_at'
    ];
    /* public function status()
    {
        return $this->belongsTo(StatusData::class, 'status_id');
    } */
    public function solicitud_servicios()
    {
        return $this->hasMany(ServicioSolicitado::class);
    }
    public static function allDA()
    {
        return self::get();
    }
    public function servicioSolicitados(): HasMany
    {
        return $this->hasMany(ServicioSolicitado::class);
    }

    public function detalleSolicitudes(): HasMany
    {
        return $this->hasMany(DetalleSolicitud::class);
    }

    public function alumno(): BelongsTo
    {
        return $this->belongsTo(Alumno::class);
    }

    public static function allall()
    {
        return self::all();
    }

    /* public static function findDA($id)
    {
        return self::whereIn('status_id', [2, 3])->find($id);
    } */
}
