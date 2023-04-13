<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Reporte de conteo de contratos de PS</title>
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
    th, td {
        font-size: 14px !important;
    }
  </style>
</head>

<body class="contrato_imprimir">
    <img class="imgUP_superior" src="{{ public_path('img/logo_sup.png') }}" alt="Logo uptrading">
    <img class="imgUP_inferior" src="{{ public_path('img/logo_latam.png') }}" alt="Logo uptrading">  

    <div style="margin-top: 8rem;">
        <table class="table table-striped table-bordered nowrap text-center tabla_resumen" style="width: 100%; padding-top: 1rem !important; padding-bottom: 3rem !important;">
            <thead>
                <tr>
                    <th data-priority="0" scope="col">PS</th>
                    <th data-priority="0" scope="col">Clientes</th>
                    <th data-priority="0" scope="col">Total</th>
                    <th data-priority="0" scope="col">Total (USD)</th>
                    <th data-priority="0" scope="col">Total (MXN)</th>
                </tr>
            </thead>
            <tbody>
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

                        $count_clientes = DB::table('contrato')
                            ->where('ps_id', $ps->id)
                            ->where('status', "Activado")
                            ->whereBetween('fecha', [$fecha_inicio, $fecha_fin])
                            ->distinct('cliente_id')
                            ->count();
                    @endphp
                    <tr>
                        <td>{{ $ps->nombre }} {{ $ps->apellido_p }} {{ $ps->apellido_m }}</td>
                        <td>{{ $count_clientes }}</td>
                        <td>{{ $count_contrato }}</td>
                        <td>${{ number_format($sum_contrato, 2) }}</td>
                        <td>${{ number_format($sum_contrato * $dolar, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <img class="imgUP_superior" src="{{ public_path('img/logo_sup.png') }}" alt="Logo uptrading">
    <img class="imgUP_inferior" src="{{ public_path('img/logo_latam.png') }}" alt="Logo uptrading">
</body>

</html>