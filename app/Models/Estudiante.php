<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estudiante extends Model
{
    use HasFactory, SoftDeletes;

    public function grado(): BelongsTo
    {
        return $this->belongsTo(Grado::class);
    }
    public function tutor(): BelongsTo
    {
        return $this->belongsTo(User::class, foreignKey: 'tutor_id');
    }
}
