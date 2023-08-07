<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grado extends Model
{
    use HasFactory, SoftDeletes;

    public function estudiantes(): HasMany
    {
        return $this->hasMany(Estudiante::class);
    }
    public function materias(): BelongsToMany
    {
        return $this->belongsToMany(Materia::class)->withPivot([
            'unidad_pedagogica',
            'periodo',
            'horas_clase',
        ]);
    }
}
