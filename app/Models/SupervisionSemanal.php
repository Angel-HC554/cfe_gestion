<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupervisionSemanal extends Model
{
    protected $table = 'supervision_semanal';
    protected $fillable = [
        'user_id',
        'vehiculo_id',
        'no_eco',
        'foto_del',
        'foto_tra',
        'foto_lado_izq',
        'foto_lado_der',
        'foto_poliza',
        'foto_tar_circ',
        'foto_kit',
        'foto_atent',
        'resumen_est',
    ];

    /**
     * Get the user that owns the supervision semanal.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class);
    }
}
