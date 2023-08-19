<?php

namespace App\Exports;

use App\Models\Nota;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class NotaExport implements FromView
{
    public function view(): View
    {
        return view('notas.export', [
            'notas' => Nota::query()->with(['materia', 'grado', 'estudiante'])->get()
        ]);
    }
}
