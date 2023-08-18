<button class="btn principal-button mb-3" data-inicio="{{$fecha_inicio}}" data-fin="{{$fecha_fin}}" id="imprimirReporte"><i class="bi bi-file-earmark-pdf-fill"></i> Imprimir reporte</button>

<table class="table table-striped table-bordered nowrap text-center" style="width: 100%" id="conteo">
    <thead>
        <tr>
            <th data-priority="0" scope="col">PS</th>
            <th data-priority="0" scope="col">Mensuales</th>
            <th data-priority="0" scope="col">Compuestos</th>
            <th data-priority="0" scope="col">Total</th>
            <th data-priority="0" scope="col">$USD</th>
            <th data-priority="0" scope="col">$EUR</th>
            <th data-priority="0" scope="col">$CHF</th>
            <th data-priority="0" scope="col">$MXN</th>
        </tr>
    </thead>
    <tbody id="psBody">
        @foreach ($lista_ps as $ps)
            @php
                $sum_contrato_eur = DB::table('contrato')
                    ->where('ps_id', $ps->id)
                    ->where('status', "Activado")
                    ->where('moneda', "euros")
                    ->whereBetween('fecha', [$fecha_inicio, $fecha_fin])
                    ->sum("inversion_eur");

                $sum_contrato_chf = DB::table('contrato')
                    ->where('ps_id', $ps->id)
                    ->where('status', "Activado")
                    ->where('moneda', "francos")
                    ->whereBetween('fecha', [$fecha_inicio, $fecha_fin])
                    ->sum("inversion_chf");

                $sum_contrato_usd = DB::table('contrato')
                    ->where('ps_id', $ps->id)
                    ->where('status', "Activado")
                    ->where('moneda', "dolares")
                    ->whereBetween('fecha', [$fecha_inicio, $fecha_fin])
                    ->sum("inversion_us");

                $sum_contrato_mxn = DB::table('contrato')
                    ->where('ps_id', $ps->id)
                    ->where('status', "Activado")
                    ->whereBetween('fecha', [$fecha_inicio, $fecha_fin])
                    ->sum("inversion");

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
                <td>${{ number_format($sum_contrato_usd, 2) }}</td>
                <td>${{ number_format($sum_contrato_eur, 2) }}</td>
                <td>${{ number_format($sum_contrato_chf, 2) }}</td>
                <td>${{ number_format($sum_contrato_mxn, 2) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>