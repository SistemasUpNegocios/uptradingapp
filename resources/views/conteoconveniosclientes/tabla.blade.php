<button class="btn principal-button mb-3" data-inicio="{{$fecha_inicio}}" data-fin="{{$fecha_fin}}" id="imprimirReporte"><i class="bi bi-file-earmark-pdf-fill"></i> Imprimir reporte</button>

<table class="table table-striped table-bordered nowrap text-center" style="width: 100%" id="conteo">
    <thead>
        <tr>
            <th data-priority="0" scope="col">Cliente</th>
            <th data-priority="0" scope="col">Convenios</th>
            <th data-priority="0" scope="col">Total</th>
            <th data-priority="0" scope="col">$USD</th>
            <th data-priority="0" scope="col">$MXN</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($lista_clientes as $cliente)
            @php
                $sum_convenio = DB::table('convenio')
                    ->where('cliente_id', $cliente->id)
                    ->where('status', "Activado")
                    ->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_fin])
                    ->sum("monto");

                $count_convenio = DB::table('convenio')
                    ->where('cliente_id', $cliente->id)
                    ->where('status', "Activado")
                    ->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_fin])
                    ->count();

                $convenios = DB::table('convenio')
                    ->select('folio')
                    ->where('cliente_id', $cliente->id)
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
                <td>{{ $cliente->nombre }} {{ $cliente->apellido_p }} {{ $cliente->apellido_m }}</td>
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