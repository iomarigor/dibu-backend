<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ConvocatoriaServicio extends Model
{
    protected $table = 'convocatoria_servicio'; 
    protected $primaryKey = 'id';
    
    public function servicio(): HasMany
    {
        return $this->hasMany(Servicio::class);
    }
}
