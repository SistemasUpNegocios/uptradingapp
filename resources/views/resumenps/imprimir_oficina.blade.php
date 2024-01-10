<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Resumen de Oficina</title>
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
    <p style="font-size: 18px; text-transform: uppercase;"><b>Resumen de la oficina @if ($oficina != "Foranea") de @endif {{ $oficina }}</b></p>
  </div>

    <table class="table table-striped table-bordered nowrap text-center tabla_resumen" style="width: 100%; padding-top: 1rem !important; padding-bottom: 3rem !important; vertical-align: middle !important; line-height: 18px;">
      <thead style="vertical-align: middle !important;">
        <tr>
          <th data-priority="0" scope="col" colspan="4" style="font-size: 16px; text-transform: uppercase;">{{ \Carbon\Carbon::parse("$fecha-10")->formatLocalized('%B') }}</th>
        </tr>
        <tr>
          <th data-priority="0" scope="col" style=" padding: 8px !important; font-size: 14px !important; vertical-align: middle !important">PS</th>
          <th data-priority="0" scope="col" style=" padding: 8px !important; font-size: 14px !important; vertical-align: middle !important">Contratos del mes anterior</th>
          <th data-priority="0" scope="col" style=" padding: 8px !important; font-size: 14px !important; vertical-align: middle !important">Acumulados</th>
          <th data-priority="0" scope="col" style=" padding: 8px !important; font-size: 14px !important; vertical-align: middle !important">Pago (USD)</th>
        </tr>
      </thead>
      <tbody id="resuemnBody" class="text-center" style="vertical-align: middle !important;">
          @php
            $total_contratos = 0;
            $total_anteriores = 0;
          @endphp
        @foreach ($lista_ps as $ps)
          @php

            $contratos = DB::table('contrato')
              ->join('ps', 'ps.id', '=', 'contrato.ps_id')
              ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
              ->join('pago_ps', 'pago_ps.contrato_id', '=', 'contrato.id')
              ->select('cliente.correo_institucional AS correocliente', 'ps.correo_institucional AS correops', 'pago_ps.pago')
              ->where('ps.id', $ps->id)
              ->where('pago_ps.fecha_limite', 'like', "$fecha%")
              ->where('ps.correo_institucional', '!=', "hamiltonherrera@uptradingexperts.com")
              ->where('ps.correo_institucional', '!=', "jorgeherrera@uptradingexperts.com")
              ->where("contrato.status", "Activado")
              ->get();

            $convenios = DB::table('convenio')
              ->join('ps', 'ps.id', '=', 'convenio.ps_id')
              ->join('cliente', 'cliente.id', '=', 'convenio.cliente_id')
              ->join('pago_ps_convenio', 'pago_ps_convenio.convenio_id', '=', 'convenio.id')
              ->select('cliente.correo_institucional AS correocliente', 'ps.correo_institucional AS correops', 'pago_ps_convenio.pago')
              ->where('ps.id', $ps->id)
              ->where('pago_ps_convenio.fecha_limite', 'like', "$fecha%")
              ->where('ps.correo_institucional', '!=', "hamiltonherrera@uptradingexperts.com")
              ->where('ps.correo_institucional', '!=', "jorgeherrera@uptradingexperts.com")
              ->where("convenio.status", "Activado")
              ->get();

            $pago_total = 0;

            foreach ($contratos as $contrato) {
              $pago_total += $contrato->pago;
            }

            foreach ($convenios as $convenio) {
              $pago_total += $convenio->pago;
            }

            $total += $pago_total;

            $fechas_consulta = explode("-", $fecha);
            $anio = $fechas_consulta[0];
            if($fechas_consulta[1] == 1){
              $mes = 12;
              $anio = $anio-1;
            }elseif($fechas_consulta[1] == 2){
              $mes = 1;
            }elseif($fechas_consulta[1] == 3){
              $mes = 2;
            }elseif($fechas_consulta[1] == 4){
              $mes = 3;
            }elseif($fechas_consulta[1] == 5){
              $mes = 4;
            }elseif($fechas_consulta[1] == 6){
              $mes = 5;
            }elseif($fechas_consulta[1] == 7){
              $mes = 6;
            }elseif($fechas_consulta[1] == 8){
              $mes = 7;
            }elseif($fechas_consulta[1] == 9){
              $mes = 8;
            }elseif($fechas_consulta[1] == 10){
              $mes = 9;
            }elseif($fechas_consulta[1] == 11){
              $mes = 10;
            }elseif($fechas_consulta[1] == 12){
              $mes = 11;
            }

            $contratos_anterior = DB::table('contrato')
              ->select('contrato')
              ->where('ps_id', $ps->id)
              ->where('ps_id', '!=', 1)
              ->where('ps_id', '!=', 2)
              ->where('status', "Activado")
              ->whereBetween('fecha', ["$anio-$mes-01", "$anio-$mes-31"])
              ->orderBy("tipo_id", "ASC")
              ->get();

            $count_anteriores = DB::table('contrato')
              ->select('contrato')
              ->where('ps_id', $ps->id)
              ->where('ps_id', '!=', 1)
              ->where('ps_id', '!=', 2)
              ->where('status', "Activado")
              ->whereBetween('fecha', ["$anio-$mes-01", "$anio-$mes-31"])
              ->count();

            $total_anteriores += $count_anteriores;

            $count_contratos = DB::table('contrato')
              ->where('ps_id', $ps->id)
              ->where('ps_id', '!=', 1)
              ->where('ps_id', '!=', 2)
              ->where('status', "Activado")
              ->count();

            $total_contratos += $count_contratos;

            $contrato_anterior = "";
            foreach ($contratos_anterior as $contrato){
              $contrato_anterior .= $contrato->contrato.", ";
            }

            $contrato_anterior = substr($contrato_anterior, 0, -2);

            if(strlen($contrato_anterior) <= 0){
              $contrato_anterior = "No hay contratos del mes";
            }
          @endphp

          <tr>
            @if ($pago_total > 0)
              <td style="font-size: 13px !important;">{{ $ps->nombre }} {{ $ps->apellido_p }} {{ $ps->apellido_m }}</td>
              <td style="font-size: 13px !important;">{{$contrato_anterior}}</td>
              <td style="font-size: 13px !important;">{{$count_contratos}}</td>
              <td style="font-size: 13px !important;">${{ number_format($pago_total, 2) }}</td>
            @endif
          </tr>

        @endforeach
        <tr>
            <td style="font-size: 14px !important;"><b>TOTAL</b></td>
            <td style="font-size: 14px !important;">{{ $total_anteriores }}</td>
            <td style="font-size: 14px !important;">{{ $total_contratos }}</td>
            <td style="font-size: 14px !important;">${{ number_format($total, 2) }}</td>
        </tr>
      </tbody>
    </table>
</body>

</html>