<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Reporte de conteo de contratos de clientes</title>
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

    <div style="margin-top: 6rem" class="text-center">
        <p style="font-size: 17px; text-transform: uppercase;"><b>Conteo de contratos de clientes</b></p>
    </div>

    <div style="margin-top: 1rem;">
        <table class="table table-striped table-bordered nowrap text-center tabla_resumen" style="width: 100%; padding-bottom: 3rem !important;">
            <thead>
                <tr>
                    <th data-priority="0" scope="col">Cliente</th>
                    <th data-priority="0" scope="col">Mensuales</th>
                    <th data-priority="0" scope="col">Compuestos</th>
                    <th data-priority="0" scope="col">Total</th>
                    <th data-priority="0" scope="col">$USD</th>
                    <th data-priority="0" scope="col">$EUR</th>
                    <th data-priority="0" scope="col">$CHF</th>
                    <th data-priority="0" scope="col">$MXN</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lista_clientes as $cliente)
                    @php
                        $sum_contrato_eur = DB::table('contrato')
                            ->where('cliente_id', $cliente->id)
                            ->where('status', "Activado")
                            ->where('moneda', "euros")
                            ->whereBetween('fecha', [$fecha_inicio, $fecha_fin])
                            ->sum("inversion_eur");

                        $sum_contrato_chf = DB::table('contrato')
                            ->where('cliente_id', $cliente->id)
                            ->where('status', "Activado")
                            ->where('moneda', "francos")
                            ->whereBetween('fecha', [$fecha_inicio, $fecha_fin])
                            ->sum("inversion_chf");

                        $sum_contrato_usd = DB::table('contrato')
                            ->where('cliente_id', $cliente->id)
                            ->where('status', "Activado")
                            ->where('moneda', "dolares")
                            ->whereBetween('fecha', [$fecha_inicio, $fecha_fin])
                            ->sum("inversion_us");

                        $sum_contrato_mxn = DB::table('contrato')
                            ->where('cliente_id', $cliente->id)
                            ->where('status', "Activado")
                            ->whereBetween('fecha', [$fecha_inicio, $fecha_fin])
                            ->sum("inversion");

                        $count_contrato = DB::table('contrato')
                            ->where('cliente_id', $cliente->id)
                            ->where('status', "Activado")
                            ->whereBetween('fecha', [$fecha_inicio, $fecha_fin])
                            ->count();

                        // Todo sobre los contratos mensuales
                        $contratos_mensuales = DB::table('contrato')
                            ->select('contrato')
                            ->where('cliente_id', $cliente->id)
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
                            ->where('cliente_id', $cliente->id)
                            ->where('status', "Activado")
                            ->where('tipo_id', 2)
                            ->whereBetween('fecha', [$fecha_inicio, $fecha_fin])
                            ->get();

                        $contratos_comp = "";
                        foreach ($contratos_compuestos as $contrato){
                            $contratos_comp .= $contrato->contrato.", ";
                        }

                        $contratos_comp = substr($contratos_comp, 0, -2);

                        //donde sea igual al dolar, otro igual a euro y otro igual al franco, multiplicar eso por su respectivo tipo de cambio y sumarlo al final para los MXN y poner sin suma en su respectiva moneda
                    @endphp
                    <tr>
                        <td>{{ $cliente->nombre }} {{ $cliente->apellido_p }} {{ $cliente->apellido_m }}</td>
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
    </div>
</body>
</html>