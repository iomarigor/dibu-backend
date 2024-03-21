<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConvocatoriaServicio extends Model
{
    protected $connection = "mysql_dbu";
    protected $table = 'convocatoria_servicio';
    protected $primaryKey = 'id';
    protected $fillable = [
        'servicio_id',
        'convocatoria_id',
        'cantidad',
    ];


    public function servicio(): BelongsTo
    {
        return $this->belongsTo(Servicio::class);
    }
}
