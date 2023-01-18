<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Reporte de {{ $cliente }}</title>
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
  <img class="imgUP_centro" src="{{ public_path('img/logo_centro.png') }}" alt="Logo uptrading">
  <img class="imgUP_inferior" src="{{ public_path('img/logo_latam.png') }}" alt="Logo uptrading">  

  <div style="padding-top: 6rem;" class="text-right">
    <p style="font-size: 12px; margin-bottom: 0 !important; color: #000">
      <b>Victoria de Durango, Durango a {{ \Carbon\Carbon::parse($fecha_imprimir)->formatLocalized('%d de %B de %Y') }}.</b>
    </p>
    <p style="font-size: 13px; color: #000">
      <u>Pago: {{ $pago }}</u>
    </p>
  </div>

  @php
    $centavos = strval($rendimiento);
    $resultCentavos = explode(".", $centavos);

    if (next($resultCentavos)) {
      if (strlen($resultCentavos[1]) == 1) {
        $centavos_num = substr($resultCentavos[1], 0, 2) . "0".'/100 M.N.';
      } else {
        $centavos_num = substr($resultCentavos[1], 0, 2).'/100 M.N.';
      }
    } else {
      $centavos_num = "00/100 M.N";
    }

    $posCON = strrpos($letra, "con");
    if($posCON === false){
      $letra = 'son '.$letra;
    }else{
      $letra = 'son '.substr_replace($letra, "", $posCON);
    }
  @endphp
  <div class="mt-5">
    <p style="font-size: 14px; !important; line-height: 15px !important; color: #000">
      <span style="margin-left: 30px;">Yo,</span> {{ $cliente }}, recibo la cantidad de ${{ $rendimiento }} M.N. ({{ $letra}} {{ $centavos_num }}), por concepto de pago de rendimiento del día {{ $fecha }} en relación con el contrato {{ $contrato }}, sin que al momento exista algún adeudo.
    </p>
  </div>

  <div class="mt-5 pt-5">
    <div class="contenedor_firma__izquierda">
      <p style="font-size: 14px; !important; color: #000; margin-top: 10px">
        QUIEN RECIBE
      </p>
      <div style="margin-left: -5.3rem !important; margin-top: 4.6rem;">
        <hr class="contenedor_firma__hr" style="width: 60% !important">        
      </div>
      <p style="font-size: 14px; !important; color: #000;">
        Nombre y Firma
      </p>
    </div>
  </div>
  <div style="margin-top: 13rem">
    <div class="contenedor_firma__izquierda">
      <div style="margin-left: -5.3rem !important; margin-top: 4.6rem;">
        <hr class="contenedor_firma__hr" style="width: 60% !important">        
      </div>
      <p style="font-size: 14px; !important; color: #000;">
        Quién entrega pago
      </p>
    </div>
  </div>
</body>

</html>