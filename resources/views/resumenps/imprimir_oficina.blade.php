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
      <thead>
        <tr>
          <th data-priority="0" scope="col" colspan="3" style="font-size: 16px; text-transform: uppercase;">{{ \Carbon\Carbon::parse("$fecha-10")->formatLocalized('%B') }}</th>
        </tr>
        <tr style="vertical-align: middle !important;">
          <th data-priority="0" scope="col">PS</th>
          <th data-priority="0" scope="col">Pago (USD)</th>
          <th data-priority="0" scope="col">Pago (MXN)</th>
        </tr>
      </thead>
      <tbody id="resuemnBody" class="text-center" style="vertical-align: middle !important;">
        @foreach ($lista_ps as $ps)
          @php

            $contratosPS = new \ArrayObject(array());
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

            foreach ($contratos as $resum) {
              $psCorreoCon = DB::table('contrato')
              ->join('ps', 'ps.id', 'contrato.ps_id')
              ->join('cliente', 'cliente.id', 'contrato.cliente_id')
              ->where('ps.id', $ps->id)
              ->where('ps.correo_institucional', $resum->correops)
              ->where('cliente.correo_institucional', $resum->correops)
              ->get();

              $psContrato = DB::table('ps')->where('correo_institucional', $resum->correocliente)->get();
              if (sizeof($psContrato) <= 0 || sizeof($psCorreoCon) > 0) {
                $contratosPS->append($resum);
              }
            }

            $conveniosPS = new \ArrayObject(array());
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

            foreach ($convenios as $resum) {
              $psCorreoCon = DB::table('convenio')
              ->join('ps', 'ps.id', 'convenio.ps_id')
              ->join('cliente', 'cliente.id', 'convenio.cliente_id')
              ->where('ps.id', $ps->id)
              ->where('ps.correo_institucional', $resum->correops)
              ->where('cliente.correo_institucional', $resum->correops)
              ->get();

              $psContrato = DB::table('ps')->where('correo_institucional', $resum->correocliente)->get();
              if (sizeof($psContrato) <= 0 || sizeof($psCorreoCon) <= 0) {
                $conveniosPS->append($resum);
              }
            }

            $pago_total = 0;

            foreach ($contratosPS as $contrato) {
              $pago_total += $contrato->pago;
            }

            foreach ($conveniosPS as $convenio) {
              $pago_total += $convenio->pago;
            }

            $total += $pago_total;

          @endphp

          <tr>
            @if ($pago_total > 0)
              <td style="font-size: 15px !important;">{{ $ps->nombre }} {{ $ps->apellido_p }} {{ $ps->apellido_m }}</td>
              <td style="font-size: 15px !important;">${{ number_format($pago_total, 2) }}</td>
              <td style="font-size: 15px !important;">${{ number_format($pago_total*$dolar, 2) }}</td>
            @endif
          </tr>

        @endforeach
        <tr>
            <td><b>TOTAL</b></td>
            <td>${{ number_format($total, 2) }}</td>
            <td>${{ number_format($total*$dolar, 2) }}</td>
        </tr>
      </tbody>
    </table>
</body>

</html>