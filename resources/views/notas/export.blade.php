<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Estudiante</th>
            <th>Grado</th>
            <th>Materia</th>
            <th>I C</th>
            <th>II C</th>
            <th>I S</th>
            <th>III C</th>
            <th>IV C</th>
            <th>II S</th>
            <th>NF</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($notas as $nota)
            <tr>
                <td>{!! $nota->id !!}</td>
                <td>{!! $nota->estudiante->nombre_completo !!}</td>
                <td>{!! $nota->grado->siglas !!}</td>
                <td>{!! $nota->materia->siglas !!}</td>
                <td>{!! $nota->nota_1_corte !!}</td>
                <td>{!! $nota->nota_2_corte !!}</td>
                <td>{!! $nota->primer_semestre !!}</td>
                <td>{!! $nota->nota_3_corte !!}</td>
                <td>{!! $nota->nota_4_corte !!}</td>
                <td>{!! $nota->segundo_semestre !!}</td>
                <td>{!! $nota->nota_final !!}</td>
            </tr>
        @endforeach
    </tbody>
</table>
