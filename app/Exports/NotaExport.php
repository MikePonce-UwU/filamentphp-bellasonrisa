<?php

namespace App\Exports;

use App\Models\Nota;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class NotaExport implements FromView
{
    public function view(): View
    {
        return view('notas.export', [
            'notas' => Nota::with([
                'estudiante',
                'materia',
                'grado',
            ])
            ->get()
        ]);
    }
}
