<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Resumen de PS</title>
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

  <div style="padding-top: 2rem" class="text-right">        
    <p style="font-size: 16px; text-transform: uppercase;"><b>MES DE {{ \Carbon\Carbon::parse("$fecha-10")->formatLocalized('%B') }}</b></p>
  </div>

  <table class="table table-striped table-bordered nowrap text-center tabla_resumen" style="width: 100%; padding-top: 3rem !important; padding-bottom: 3rem !important;">
    <thead>
      <tr>
        <th data-priority="0" colspan="3"scope="col" style="font-size: 16px !important;">{{ $ps->nombre }} {{ $ps->apellido_p }} {{ $ps->apellido_m }}</th>
        <th data-priority="0" colspan="2" scope="col">Total: <span style="font-weight: 500; font-size: 15px !important;">${{ $total }}</span></th>
      </tr>
      <tr>
        <th data-priority="0" scope="col">Tipo</th>
        <th data-priority="0" scope="col">Cliente</th>
        <th data-priority="0" scope="col">Comisión</th>
        <th data-priority="0" scope="col">Tipo de comisión</th>
        <th data-priority="0" scope="col">Pago</th>
      </tr>
    </thead>
    <tbody id="resuemnBody">
      @foreach ($resumenes_contrato as $resumen)                                
        <tr>
          <td style="font-size: 15px !important;">
            @if (strlen($resumen->contrato) == 11)
              {{ substr($resumen->contrato, 0, -2); }}
            @else
              {{ substr($resumen->contrato, 0, -3); }}
            @endif
          </td>
          <td style="font-size: 15px !important;">{{ $resumen->clientenombre }}</td>
          <td style="font-size: 15px !important;">${{ number_format($resumen->pago, 2) }}</td>
          <td style="font-size: 15px !important;">{{ $resumen->memo }}</td>
          <td style="font-size: 15px !important;">
            @if ($resumen->memo == "Comisión por apertura")
              {{ str_pad($resumen->serie, 2, "0", STR_PAD_LEFT) }}/01
            @else
              {{ str_pad($resumen->serie, 2, "0", STR_PAD_LEFT) }}/12
            @endif
          </td>
        </tr>
      @endforeach
      @foreach ($resumenes_convenio as $resumen)                                
        <tr>
          <td style="font-size: 15px !important;">
            @php
              $convenio = explode('-', $resumen->folio);
              $convenio = "$convenio[1]-$convenio[2]-$convenio[3]";
            @endphp
            {{ $convenio }}
          </td>
          <td style="font-size: 15px !important;">{{ $resumen->clientenombre }}</td>
          <td style="font-size: 15px !important;">${{ number_format($resumen->pago, 2) }}</td>
          <td style="font-size: 15px !important;">{{ $resumen->memo }}</td>
          <td style="font-size: 15px !important;">
            @if ($resumen->memo == "Comisión por apertura")
              {{ str_pad($resumen->serie, 2, "0", STR_PAD_LEFT) }}/01
            @else
              {{ str_pad($resumen->serie, 2, "0", STR_PAD_LEFT) }}/12
            @endif
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</body>

</html>