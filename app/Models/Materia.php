<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Materia extends Model
{
    use HasFactory, SoftDeletes;

    public function grados(): BelongsToMany
    {
        return $this->belongsToMany(Grado::class)->withPivot([
            'unidad_pedagogica',
            'periodo',
            'horas_clase',
        ]);
    }
}