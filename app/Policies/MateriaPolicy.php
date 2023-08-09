<?php

namespace App\Policies;

use App\Models\Materia;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MateriaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
        return $user->hasRole(['Admin']) || $user->current_role->name === 'Maestro' || $user->current_role->name === 'Director';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Materia $materia): bool
    {
        //
        // dd(count($user->whereHas('materias', function ($q) use ($materia) {
        //     $q->where('materia_id', '=', $materia->id);
        // })->get()));
        return $user->hasRole(['Admin']) || $user->current_role->name === 'Director' || $user->current_role->name === 'Maestro';
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
        return $user->hasRole(['Admin']) || $user->current_role->name === 'Director';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Materia $materia): bool
    {
        //
        return $user->hasRole(['Admin']) || count($user->whereHas('materias', function ($q) use ($materia) {
            $q->where('materia_id', '=', $materia->id);
        })->get()) > 0 || $user->current_role->name === 'Director';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Materia $materia): bool
    {
        //
        return $user->hasRole(['Admin']) || $user->current_role->name === 'Director';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Materia $materia): bool
    {
        //
        return $user->hasRole(['Admin']) || $user->current_role->name === 'Director';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Materia $materia): bool
    {
        //
        return $user->hasRole(['Admin']) || $user->current_role->name === 'Director';
    }
}
