<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>MAM {{ $cliente }}</title>
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
    th {
        font-size: 14px !important;
        font-weight: 400 !important;
    }
    td {
        font-size: 14px !important;
    }
    .parrafo_cuenta{
        font-size: 14px !important; 
        line-height: 12px !important; 
        color: #000; 
        text-align: justify
    }
    .clausula_cuenta {
        font-size: 10px !important; 
        line-height: 12px !important; 
        color: #000; 
        text-align: justify;
    }
    table {
        width: 70%; 
        padding-top: 1rem !important; 
        padding-bottom: 3rem !important; 
        margin: 0 auto !important; 
        border-color: #000 !important;
    }
  </style>
</head>

<body class="contrato_imprimir">
  <img class="imgUP_superior" src="{{ public_path('img/logo_sup.png') }}" alt="Logo uptrading">
  <img class="imgUP_centro" src="{{ public_path('img/logo_centro.png') }}" alt="Logo uptrading">
  <img class="imgUP_inferior" src="{{ public_path('img/logo_latam.png') }}" alt="Logo uptrading">  

  <div style="padding-top: 6rem;" class="text-right">
    <p style="font-size: 12px; margin-bottom: 0 !important; color: #000">
      <b>Victoria de Durango, Durango a {{ $fecha_impresion }}.</b>
      <br>
      <span style="font-size: 14px !important;"><b>Periodo {{$serie}}</b></span>
    </p>
  </div>

  <div class="mt-5 mr-5 ml-5 mb-3">
    <p class="parrafo_cuenta">
        {{-- De conformidad con el convenio <b>{{$folio}}</b> de cuenta MAM a nombre de <b>{{$cliente}}</b> con login <b>{{$loggin}}</b>, se hace de su conocimiento, que al día de hoy con respecto a la operativa que se ha llevado en este periodo, tenemos como resultado acumulado, lo siguiente: --}}
        De conformidad con el convenio a nombre de <b>{{$cliente}}</b> con login <b>{{$loggin}}</b>, se hace de su conocimiento, que al día de hoy con respecto a la operativa que se ha llevado en este periodo, tenemos como resultado acumulado, lo siguiente:
    </p>
  </div>

  <table class="table table-striped table-bordered nowrap text-center tabla_resumen pr-5 pl-5">
    <thead style="vertical-align: middle !important">
      <tr>
        <th data-priority="0" scope="col"><b>Fecha inicio</b></th>
        <th data-priority="0" scope="col">{{ $fecha_inicio }}</th>
      </tr>
    </thead>
    <tbody>
        <tr>
            <td><b>Capital inicial de inversión</b></td>
            <td>${{$capital}}</td>
        </tr>
        <tr>
            <td><b>Aumento a capital</b></td>
            <td>${{$aumento}}</td>
        </tr>
        <tr>
          <td><b>Fecha de aumento a capital</b></td>
          <td>{{$fecha_aumento}}</td>
        </tr>
        <tr>
            <td><b>Balance de la cuenta</b></td>
            <td>${{$balance}}</td>
        </tr>
        <tr>
            <td><b>Flotante total</b></td>
            <td>${{$flotante}}</td>
        </tr>
        <tr>
            <td><b>Retiro sugerido</b></td>
            <td>${{$retiro}}</td>
        </tr>
    </tbody>
  </table>
  
  <div class="mr-5 ml-5">
    <p class="parrafo_cuenta">
        De igual manera, te recordamos que, para disponer de la cantidad sugerida, deberá cumplir con las cláusulas del convenio, mismo que citamos a continuación:
    </p>
    <p class="clausula_cuenta" style="margin-top: -2px !important;">
        V. "EL CLIENTE" si así lo decide y opta por realizar un retiro parcial o total de su rendimiento, este se realizará con una transferencia a la tarjeta emitida por el banco SWISSQUOTE, o a otro medio de dispersión que el cliente decida y que sea factible de realizar.
    </p>
    <p class="clausula_cuenta" style="margin-top: -7px !important;">
        VI. "EL CLIENTE" en todo momento tiene el derecho de retirar sus rendimientos, en cualquiera de sus 3 (tres) revisiones trimestrales, a las que tiene derecho durante la vigencia de su contrato de operación de cuenta MAM. Lo anterior quiere decir, que sin importar en cual revisión trimestral, "EL CLIENTE" puede hacer uso de sus rendimientos siempre y cuando en ningún caso el retiro disminuya la cantidad con la que se celebró el contrato del cual se desprende este convenio
    </p>
    <p class="parrafo_cuenta" style="margin-top: -2px !important;">
        Nota: al realizar el retiro de sus rendimientos es necesario enviarnos el comprobante de dicho retiro.
    </p>
    <p class="parrafo_cuenta" style="margin-top: -7px !important;">
        Quedamos a sus órdenes, para cualquier duda o aclaración. Saludos cordiales.
    </p>

    <p class="parrafo_cuenta" style="text-align: center !important; margin-top: 60px !important;"><b>Atentamente.</b></p>
    <p class="parrafo_cuenta" style="text-align: center !important; margin-top: -10px !important;"><b>Up Trading Experts</b></p>
  </div>

</body>

</html>