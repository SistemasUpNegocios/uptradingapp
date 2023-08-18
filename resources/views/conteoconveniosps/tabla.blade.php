<button class="btn principal-button mb-3" data-inicio="{{$fecha_inicio}}" data-fin="{{$fecha_fin}}" id="imprimirReporte"><i class="bi bi-file-earmark-pdf-fill"></i> Imprimir reporte</button>

<table class="table table-striped table-bordered nowrap text-center" style="width: 100%" id="conteo">
    <thead>
        <tr>
            <th data-priority="0" scope="col">PS</th>
            <th data-priority="0" scope="col">Convenios</th>
            <th data-priority="0" scope="col">Total</th>
            <th data-priority="0" scope="col">$USD</th>
            <th data-priority="0" scope="col">$MXN</th>
        </tr>
    </thead>
    <tbody id="psBody">
        @foreach ($lista_ps as $ps)
            @php
                $sum_convenio = DB::table('convenio')
                    ->where('ps_id', $ps->id)
                    ->where('status', "Activado")
                    ->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_fin])
                    ->sum("monto");

                $count_convenio = DB::table('convenio')
                    ->where('ps_id', $ps->id)
                    ->where('status', "Activado")
                    ->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_fin])
                    ->count();

                $convenios = DB::table('convenio')
                    ->select('folio')
                    ->where('ps_id', $ps->id)
                    ->where('status', "Activado")
                    ->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_fin])
                    ->get();

                $conv = "";
                foreach ($convenios as $convenio){
                    $conv .= $convenio->folio.", ";
                }

                $conv = substr($conv, 0, -2);
            @endphp
            <tr>
                <td>{{ $ps->nombre }} {{ $ps->apellido_p }} {{ $ps->apellido_m }}</td>
                <td>
                    @if (strlen($conv) > 0)
                        {{$conv}}.
                    @else
                        <b>No se encontraron resultados</b>
                    @endif
                </td>
                <td>{{ $count_convenio }}</td>
                <td>${{ number_format($sum_convenio, 2) }}</td>
                <td>${{ number_format($sum_convenio * $dolar, 2) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>