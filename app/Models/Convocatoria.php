<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Convocatoria extends Model
{
    protected $table = 'convocatorias'; 
    protected $primaryKey = 'id';
    protected $fillable = [
        'fecha_inicio', 
        'fecha_fin', 
        'nombre',
        'user_id'
    ];
    
    public function convocatoriaServicio(): HasMany
    {
        return $this->hasMany(ConvocatoriaServicio::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}