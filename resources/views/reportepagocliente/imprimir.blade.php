<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Resumen de pagos a clientes</title>
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
    <p style="font-size: 16px; text-transform: uppercase;">
      Reporte del <b>{{ \Carbon\Carbon::parse($fecha_inicio)->formatLocalized('%d de %B de %Y') }}</b> 
      hasta el <b>{{ \Carbon\Carbon::parse($fecha_fin)->formatLocalized('%d de %B de %Y') }}</b>
    </p>
  </div>

  <table class="table table-striped table-bordered nowrap text-center tabla_resumen" style="width: 100%; padding-top: 1rem !important; padding-bottom: 3rem !important;">
    <thead>
      <tr>
        <th data-priority="0" scope="col">Contrato</th>
        <th data-priority="0" scope="col">Cliente</th>
        <th data-priority="0" scope="col">Rendimiento (USD)</th>
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
          <td style="font-size: 15px !important;">
            @if ($resumen->serie == 13)
              CONTRATO COMPUESTO
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