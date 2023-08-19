<?php

namespace App\Http\Controllers;

use App\Exports\NotaExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class NotaController extends Controller
{
    //
    public function export()
    {
        return Excel::download(new NotaExport, 'notas-export.'.now()->format('Y.m.d'). '.csv', \Maatwebsite\Excel\Excel::CSV);
    }
}
