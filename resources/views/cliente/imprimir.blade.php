<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>CUENTAS MAM</title>
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
  </style>
</head>

<body class="contrato_imprimir">
    <img class="imgUP_superior" src="{{ public_path('img/logo_sup.png') }}" alt="Logo uptrading">

    <div style="padding-top: 6rem" class="text-center">
        <p style="font-size: 16px;"><b>CLIENTES CON CUENTA MAM</b></p>
    </div>

    <table class="table table-striped table-bordered nowrap text-center tabla_resumen" style="width: 100%; padding-top: 1rem !important; ">
        <thead>
            <tr>
                <th data-priority="0" scope="col" style="vertical-align: middle !important; font-size: 13px !important; padding: 0 5px !important;">Nombre del cliente</th>
                <th data-priority="0" scope="col" style="vertical-align: middle !important; font-size: 13px !important; padding: 0 5px !important;">Número de cuenta</th>
                <th data-priority="0" scope="col" style="vertical-align: middle !important; font-size: 13px !important; padding: 0 5px !important;">Loggin</th>
                <th data-priority="0" scope="col" style="vertical-align: middle !important; font-size: 13px !important; padding: 0 10px !important;">Monto (USD)</th>
                <th data-priority="0" scope="col" style="vertical-align: middle !important; font-size: 13px !important; padding: 0 5px !important;">Fecha de inicio</th>
                <th data-priority="0" scope="col" style="vertical-align: middle !important; font-size: 13px !important; padding: 0 5px !important;">Incremento</th>
                <th data-priority="0" scope="col" style="vertical-align: middle !important; font-size: 13px !important; padding: 0 5px !important;">Fecha de incremento</th>
                <th data-priority="0" scope="col" style="vertical-align: middle !important; font-size: 13px !important; padding: 0 5px !important;">Monto incrementado</th>
                <th data-priority="0" scope="col" style="vertical-align: middle !important; font-size: 13px !important; padding: 0 5px !important;">Periodo</th>
            </tr>
        </thead>
        <tbody id="resuemnBody">
            @foreach ($informacion as $info)
                @php
                    $incrementos = \App\Models\IncrementoConvenio::select()
                    ->where('convenio_id', $info->convenioid)
                    ->first();

                    $incrementos_count = \App\Models\IncrementoConvenio::select()
                    ->where('convenio_id', $info->convenioid)
                    ->count();

                    $mes = \Carbon\Carbon::parse($info->fecha_inicio)->format("m");
                    $anio = \Carbon\Carbon::parse($info->fecha_inicio)->format("Y");

                    $fecha_inicio = \Carbon\Carbon::parse("01-$mes-$anio");
                    $fecha_actual = \Carbon\Carbon::now();

                    $periodo = $fecha_actual->diffInMonths($fecha_inicio);
                    
                    if($periodo > 12){
                        $periodo = 12;
                    }elseif($periodo == 0){
                        $periodo = 1;
                    }
                @endphp
                <tr>
                    <td style="vertical-align: middle !important; font-size: 13px !important; padding: 5px 10px !important;">
                        {{ $info->nombre }} {{ $info->apellido_p }} {{ $info->apellido_m }}
                    </td>
                    <td style="vertical-align: middle !important; font-size: 13px !important; padding: 5px 10px !important;">{{ $info->numerocuenta }}</td>
                    <td style="vertical-align: middle !important; font-size: 13px !important; padding: 5px 10px !important;">{{ $info->loggin }}</td>
                    <td style="vertical-align: middle !important; font-size: 13px !important; padding: 5px 10px !important;">${{ number_format($info->monto, 2) }}</td>
                    <td style="vertical-align: middle !important; font-size: 13px !important; padding: 5px 10px !important;">
                        {{ \Carbon\Carbon::parse($info->fecha_inicio)->format("d/m/Y") }}
                    </td>
                    <td style="vertical-align: middle !important; font-size: 13px !important; padding: 5px 10px !important;">
                        @if ($incrementos_count > 0) SI @else NO @endif
                    </td>
                    <td style="vertical-align: middle !important; font-size: 13px !important; padding: 5px 10px !important;">
                        @if ($incrementos_count > 0)
                            {{\Carbon\Carbon::parse($incrementos->fecha_inicio_incremento)->format("d/m/Y")}}
                        @else
                            NA
                        @endif
                    </td>
                    <td style="vertical-align: middle !important; font-size: 13px !important; padding: 5px 10px !important;">
                        @if ($incrementos_count > 0)
                            ${{number_format($incrementos->cantidad_incremento, 2)}}
                        @else
                            NA
                        @endif
                    </td>
                    <td style="vertical-align: middle !important; font-size: 13px !important; padding: 5px 10px !important;">
                        {{$periodo}}/12
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>