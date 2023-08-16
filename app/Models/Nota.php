<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nota extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'estudiante_id',
        'grado_id',
        'materia_id',
        'nota_1_corte',
        'nota_2_corte',
        'nota_3_corte',
        'nota_4_corte',
    ];
    public function primerSemestre(): Attribute
    {
        // dd($this->attributes);
        return Attribute::make(
            get: fn (): string => ($this->attributes['nota_1_corte'] + $this->attributes['nota_2_corte']) / 2
        );
    }
    public function segundoSemestre(): Attribute
    {
        // dd($this->attributes);
        return Attribute::make(
            get: fn (): string => ($this->attributes['nota_3_corte'] + $this->attributes['nota_4_corte']) / 2
        );
    }
    public function notaFinal(): Attribute
    {
        // dd($this->attributes);
        return Attribute::make(
            get: fn (): string => ($this->attributes['nota_1_corte'] + $this->attributes['nota_2_corte'] + $this->attributes['nota_3_corte'] + $this->attributes['nota_4_corte']) / 4
        );
    }
    public function materia(): BelongsTo
    {
        return $this->belongsTo(Materia::class);
    }
    public function grado(): BelongsTo
    {
        return $this->belongsTo(Grado::class);
    }
    public function estudiante(): BelongsTo
    {
        return $this->belongsTo(Estudiante::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
