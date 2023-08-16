<?php

namespace App\Filament\Resources\NotaResource\Pages;

use App\Filament\Resources\NotaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListNotas extends ListRecords
{
    protected static string $resource = NotaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    public function getTabs(): array
    {
        $_materias = auth()->user()->materias;
        // dd(auth()->user()->is_admin());
        if (auth()->user()->is_admin()) {
            $_materias = \App\Models\Materia::all();
        }
        $returnState = [
            'all' => Tab::make(),
        ];
        foreach ($_materias as $key) :
            $tabName = str()->upper($key->siglas);
            $returnState[$tabName] = Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('materia_id', $key->id));
        endforeach;
        return collect($returnState)->toArray();

        /**
         * [
         *       $item->nombre_completo => Tab::make()->modifyQueryUsing(fn (Builder $query) => $query->where('materia_id', $item->id))
         *   ]
         */
    }
}
