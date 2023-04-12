<table class="table table-striped table-bordered nowrap text-center" style="width: 100%" id="conteo">
    <thead>
        <tr>
            <th data-priority="0" scope="col">Nombre</th>
            <th data-priority="0" scope="col">Mensuales</th>
            <th data-priority="0" scope="col">Compuestos</th>
            <th data-priority="0" scope="col">Total</th>
            <th data-priority="0" scope="col">$USD</th>
        </tr>
    </thead>
    <tbody id="psBody">
        @foreach ($lista_ps as $ps)
            @php
                $sum_contrato = DB::table('contrato')
                    ->where('ps_id', $ps->id)
                    ->where('status', "Activado")
                    ->whereBetween('fecha', [$fecha_inicio, $fecha_fin])
                    ->sum("inversion_us");

                $count_contrato = DB::table('contrato')
                    ->where('ps_id', $ps->id)
                    ->where('status', "Activado")
                    ->whereBetween('fecha', [$fecha_inicio, $fecha_fin])
                    ->count();

                // Todo sobre los contratos mensuales
                $contratos_mensuales = DB::table('contrato')
                    ->select('contrato')
                    ->where('ps_id', $ps->id)
                    ->where('status', "Activado")
                    ->where('tipo_id', 1)
                    ->whereBetween('fecha', [$fecha_inicio, $fecha_fin])
                    ->get();

                $contratos_men = "";
                foreach ($contratos_mensuales as $contrato){
                    $contratos_men .= $contrato->contrato.", ";
                }

                $contratos_men = substr($contratos_men, 0, -2);

                // Todo sobre los contratos compuestos
                $contratos_compuestos = DB::table('contrato')
                    ->select('contrato')
                    ->where('ps_id', $ps->id)
                    ->where('status', "Activado")
                    ->where('tipo_id', 2)
                    ->whereBetween('fecha', [$fecha_inicio, $fecha_fin])
                    ->get();

                $contratos_comp = "";
                foreach ($contratos_compuestos as $contrato){
                    $contratos_comp .= $contrato->contrato.", ";
                }

                $contratos_comp = substr($contratos_comp, 0, -2);
            @endphp
            <tr>
                <td>{{ $ps->nombre }} {{ $ps->apellido_p }} {{ $ps->apellido_m }}</td>
                <td>
                    @if (strlen($contratos_men) > 0)
                        {{$contratos_men}}.
                    @else
                        <b>No se encontraron resultados</b>
                    @endif
                </td>
                <td>
                    @if (strlen($contratos_comp) > 0)
                        {{$contratos_comp}}.
                    @else
                        <b>No se encontraron resultados</b>
                    @endif
                </td>
                <td>{{ $count_contrato }}</td>
                <td>${{ number_format($sum_contrato, 2) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>