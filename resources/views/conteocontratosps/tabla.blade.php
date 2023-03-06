<table class="table table-striped table-bordered nowrap text-center" id="ps">
    <thead>
        <tr>
            <th data-priority="0" scope="col">Código PS</th>
            <th data-priority="0" scope="col">Nombre</th>
            <th data-priority="0" scope="col">Mensuales</th>
            <th data-priority="0" scope="col">Compuestos</th>
            <th data-priority="0" scope="col">Total</th>
            <th data-priority="0" scope="col">Convenios</th>
        </tr>
    </thead>
    <tbody id="psBody">
        @foreach ($lista_ps as $ps)
            @php
                $count_contrato = DB::table('contrato')
                    ->where('ps_id', $ps->id)
                    ->where('status', "Activado")
                    ->whereBetween('fecha', [$fecha_inicio, $fecha_fin])
                    ->count();

                $count_mensual = DB::table('contrato')
                    ->where('ps_id', $ps->id)
                    ->where('status', "Activado")
                    ->where('tipo_id', 1)
                    ->whereBetween('fecha', [$fecha_inicio, $fecha_fin])
                    ->count();

                $count_compuesto = DB::table('contrato')
                    ->where('ps_id', $ps->id)
                    ->where('status', "Activado")
                    ->where('tipo_id', 2)
                    ->whereBetween('fecha', [$fecha_inicio, $fecha_fin])
                    ->count();

                $count_convenio = DB::table('convenio')
                    ->where('ps_id', $ps->id)
                    ->where('status', "Activado")
                    ->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_fin])
                    ->count();

            @endphp
            <tr>
                <td>{{ $ps->codigoPS }}</td>
                <td>{{ $ps->nombre }} {{ $ps->apellido_p }} {{ $ps->apellido_m }}</td>
                <td>{{ $count_mensual }}</td>
                <td>{{ $count_compuesto }}</td>
                <td>{{ $count_contrato }}</td>
                <td>{{ $count_convenio }}</td>
            </tr>
        @endforeach
    </tbody>
</table>