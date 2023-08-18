<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Reporte de conteo de convenios de clientes</title>
  <meta content="" name="description">

  <link rel="shortcut icon" href="{{ public_path('img/favicon.png') }}" type="image/x-icon">
  <link rel="icon" href="{{ public_path('img/favicon.png') }}" type="image/x-icon">
  <link href="{{ public_path('img/favicon.png') }}" rel="apple-touch-icon">
  
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <link href="{{ public_path('css/style.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ public_path('css/preloader.css') }}" rel="stylesheet" type="text/css">

  <style>
    .page-break {
      page-break-after: always;
    }
    th{
        font-size: 14px !important;
        padding: 0 6px !important;
    }
    td {
        font-size: 13px !important;
        padding: 0 6px !important;
    }
  </style>
</head>

<body class="contrato_imprimir">
    <img class="imgUP_superior" src="{{ public_path('img/logo_sup.png') }}" alt="Logo uptrading">
    <img class="imgUP_inferior" src="{{ public_path('img/logo_latam.png') }}" alt="Logo uptrading">  

    <div style="margin-top: 6rem;">
        <div style="margin-bottom: 1rem" class="text-center">
            <p style="font-size: 17px; text-transform: uppercase;"><b>Conteo de convenios de clientes</b></p>
        </div>
        
        <table class="table table-striped table-bordered nowrap text-center tabla_resumen" style="width: 100%; padding-bottom: 6rem !important;">
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
    </div>
</body>
</html>