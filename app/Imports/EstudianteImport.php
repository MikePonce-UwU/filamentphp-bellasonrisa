<?php

namespace App\Imports;

use App\Models\Estudiante;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EstudianteImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        dd($row);
        return new Estudiante([
            //
            'codigo_estudiante' => $row['codigo_estudiante'],
            'nombre_completo' => $row['nombre_completo'],
            'sexo' => $row['sexo'],
            'fecha_nacimiento' => $row['fecha_nacimiento'],
            'cedula' => $row['cedula'],
            'telefono' => $row['telefono'],
            'lugar_nacimiento' => $row['lugar_nacimiento'],
            'direccion' => $row['direccion'],
            'expediente_medico' => $row['expediente_medico'],
            'grado_id' => $row['grado_id'],
            'tutor_id' => $row['tutor_id'],
        ]);
    }
}
