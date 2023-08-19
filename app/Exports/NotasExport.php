<?php

namespace App\Exports;

use App\Models\Nota;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;

class NotasExport implements FromView
{
    private $notas;
    public function __construct(Collection $notas)
    {
        $this->notas = $notas->load(['materia', 'grado', 'estudiante']);
    }
    public function view(): View
    {
        return view('notas.export', [
            'notas' => $this->notas,
        ]);
    }
}
