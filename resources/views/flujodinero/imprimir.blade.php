<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Flujo de dinero del mes de {{ $fecha }}</title>
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

    <div style="padding-top: 5rem" class="text-center">
        <p style="font-size: 18px; text-transform: uppercase;">
            <b>
                Reporte de flujo de dinero 
                @if (strlen($fecha) > 0)
                    del mes de {{ \Carbon\Carbon::parse("$fecha-01")->formatLocalized('%B') }}
                @else
                    total
                @endif
            </b>
        </p>
    </div>

    <div class="mb-4">
        <div>
            <div style="float: left; width: 50%; margin: auto;">
                <div class=" text-center">
                    <p style="margin: 0 !important; font-size: 13px !important"><b>Wise:</b> ${{ $total_wise }}</p>
                    <p style="margin: 0 !important; font-size: 13px !important"><b>HSBC:</b> ${{ $total_HSBC }}</p>
                    <p style="margin: 0 !important; font-size: 13px !important"><b>MX a POOL:</b> ${{ $total_mx_pool }}</p>
                    <p style="margin: 0 !important; font-size: 13px !important"><b>Efectivo:</b> ${{ $total_efectivo }}</p>            
                </div>
            </div>
            <div style="float: right; width: 50%;">
                <div class="text-center">
                    <p style="margin: 0 !important; font-size: 13px !important"><b>CI BANK:</b> ${{ $total_ci_bank }}</p>
                    <p style="margin: 0 !important; font-size: 13px !important"><b>Comisiones:</b> ${{ $total_comisiones }}</p>
                    <p style="margin: 0 !important; font-size: 13px !important"><b>Renovaciones:</b> ${{ $total_renovacion }}</p>
                    <p style="margin: 0 !important; font-size: 13px !important"><b>Rendimientos:</b> ${{ $total_rendimientos }}</p>
                </div>
            </div>
        </div>
        <div style="margin-top: 4.5rem; text-align: center">
            <p style="margin: 0 !important; font-size: 13px !important"><b>Swissquote a POOL:</b> ${{ $total_swiss_pool }}</p>
            <p style="margin: 0 !important; font-size: 13px !important"><b>Total final:</b> ${{ $total_final }}</p>
        </div>
    </div>

    <table class="tabla_reverso table-sm table-striped" style="width: 100% !important; padding: auto !important; font-size: 10px !important;" id="flujoDinero">
        <thead style="border-bottom: 1px solid #bebebe !important; border-top: 1px solid #bebebe !important;">
            <tr>
                <th data-priority="0" scope="col" style="padding: 2px !important; border-left: 1px solid #bebebe !important; width: 80px !important">Contrato</th>
                <th data-priority="0" scope="col" style="padding: 2px !important; border-left: 1px solid #bebebe !important;">Fecha</th>
                <th data-priority="0" scope="col" style="padding: 2px !important; border-left: 1px solid #bebebe !important;">Cliente</th>
                <th data-priority="0" scope="col" style="padding: 2px !important; border-left: 1px solid #bebebe !important;">PS</th>

                <th data-priority="0" scope="col" style="padding: 2px !important; border-left: 1px solid #bebebe !important;">Swissquote a POOL</th>
                <th data-priority="0" scope="col" style="padding: 2px !important; border-left: 1px solid #bebebe !important;">Rendimientos</th>
                <th data-priority="0" scope="col" style="padding: 2px !important; border-left: 1px solid #bebebe !important;">Renovación</th>
                <th data-priority="0" scope="col" style="padding: 2px !important; border-left: 1px solid #bebebe !important;">Comisiones</th>
                <th data-priority="0" scope="col" style="padding: 2px !important; border-left: 1px solid #bebebe !important;">MX a POOL</th>
                <th data-priority="0" scope="col" style="padding: 2px !important; border-left: 1px solid #bebebe !important;">Efectivo</th>
                <th data-priority="0" scope="col" style="padding: 2px !important; border-left: 1px solid #bebebe !important;">CI BANK</th>
                <th data-priority="0" scope="col" style="padding: 2px !important; border-left: 1px solid #bebebe !important;">HSBC</th>
                <th data-priority="0" scope="col" style="padding: 2px !important; border-left: 1px solid #bebebe !important; border-right: 1px solid #bebebe !important;">WISE</th>
            </tr>
        </thead>
        <tbody id="flujoDineroBody">
            @foreach ($flujodinero as $flujo)
                @php
                    $tipo_pago = explode(",", $flujo->tipo_pago);
                    $monto_pago = explode(",", $flujo->monto_pago);
                @endphp
                <tr>
                    <td style="width: 80px !important; padding: 2px 6px !important; border-left: 1px solid #bebebe !important; border-bottom: 1px solid #bebebe !important;">{{ $flujo->contrato }}</td>
                    <td style="padding: 2px 6px !important; border-left: 1px solid #bebebe !important; border-bottom: 1px solid #bebebe !important;">{{ \Carbon\Carbon::parse($flujo->fecha)->format('d/m/Y') }}</td>
                    <td style="padding: 2px 6px !important; border-left: 1px solid #bebebe !important; border-bottom: 1px solid #bebebe !important;">{{ $flujo->clientenombre }}</td>
                    <td style="padding: 2px 6px !important; border-left: 1px solid #bebebe !important; border-bottom: 1px solid #bebebe !important;">{{ $flujo->psnombre }}</td>

                    <td style="padding: 2px 6px !important; border-left: 1px solid #bebebe !important; border-bottom: 1px solid #bebebe !important;">
                        @php $pago = number_format(0, 2); @endphp

                        @for ($i=0; $i < sizeof($tipo_pago); $i++)
                            @if($tipo_pago[$i] == "transferencia_swiss_pool")
                                @php $pago = number_format($monto_pago[$i], 2); @endphp
                            @endif
                        @endfor

                        ${{ $pago }}
                    </td>
                    <td style="padding: 2px 6px !important; border-left: 1px solid #bebebe !important; border-bottom: 1px solid #bebebe !important;">
                        @php $pago = number_format(0, 2); @endphp

                        @for ($i=0; $i < sizeof($tipo_pago); $i++)
                            @if($tipo_pago[$i] == "rendimientos")
                                @php $pago = number_format($monto_pago[$i], 2); @endphp
                            @endif
                        @endfor

                        ${{ $pago }}
                    </td>
                    <td style="padding: 2px 6px !important; border-left: 1px solid #bebebe !important; border-bottom: 1px solid #bebebe !important;">
                        @php $pago = number_format(0, 2); @endphp

                        @for ($i=0; $i < sizeof($tipo_pago); $i++)
                            @if($tipo_pago[$i] == "renovacion")
                                @php $pago = number_format($monto_pago[$i], 2); @endphp
                            @endif
                        @endfor

                        ${{ $pago }}
                    </td>
                    <td style="padding: 2px 6px !important; border-left: 1px solid #bebebe !important; border-bottom: 1px solid #bebebe !important;">
                        @php $pago = number_format(0, 2); @endphp

                        @for ($i=0; $i < sizeof($tipo_pago); $i++)
                            @if($tipo_pago[$i] == "comisiones")
                                @php $pago = number_format($monto_pago[$i], 2); @endphp
                            @endif
                        @endfor

                        ${{ $pago }}
                    </td>
                    <td style="padding: 2px 6px !important; border-left: 1px solid #bebebe !important; border-bottom: 1px solid #bebebe !important;">
                        @php $pago = number_format(0, 2); @endphp

                        @for ($i=0; $i < sizeof($tipo_pago); $i++)
                            @if($tipo_pago[$i] == "transferencia_mx_pool")
                                @php $pago = number_format($monto_pago[$i], 2); @endphp
                            @endif
                        @endfor

                        ${{ $pago }}
                    </td>
                    <td style="padding: 2px 6px !important; border-left: 1px solid #bebebe !important; border-bottom: 1px solid #bebebe !important;">
                        @php $pago = number_format(0, 2); @endphp

                        @for ($i=0; $i < sizeof($tipo_pago); $i++)
                            @if($tipo_pago[$i] == "efectivo")
                                @php $pago = number_format($monto_pago[$i], 2); @endphp
                            @endif
                        @endfor

                        ${{ $pago }}
                    </td>
                    <td style="padding: 2px 6px !important; border-left: 1px solid #bebebe !important; border-bottom: 1px solid #bebebe !important;">
                        @php $pago = number_format(0, 2); @endphp

                        @for ($i=0; $i < sizeof($tipo_pago); $i++)
                            @if($tipo_pago[$i] == "ci_bank")
                                @php $pago = number_format($monto_pago[$i], 2); @endphp
                            @endif
                        @endfor

                        ${{ $pago }}
                    </td>
                    <td style="padding: 2px 6px !important; border-left: 1px solid #bebebe !important; border-bottom: 1px solid #bebebe !important;">
                        @php $pago = number_format(0, 2); @endphp

                        @for ($i=0; $i < sizeof($tipo_pago); $i++)
                            @if($tipo_pago[$i] == "HSBC")
                                @php $pago = number_format($monto_pago[$i], 2); @endphp
                            @endif
                        @endfor

                        ${{ $pago }}
                    </td>
                    <td style="padding: 2px 6px !important; border-left: 1px solid #bebebe !important; border-bottom: 1px solid #bebebe !important; border-right: 1px solid #bebebe !important;">
                        @php $pago = number_format(0, 2); @endphp

                        @for ($i=0; $i < sizeof($tipo_pago); $i++)
                            @if($tipo_pago[$i] == "wise")
                                @php $pago = number_format($monto_pago[$i], 2); @endphp
                            @endif
                        @endfor

                        ${{ $pago }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>