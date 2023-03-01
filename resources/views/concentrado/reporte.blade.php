<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Reporte de concentrado</title>
  <meta content="" name="description">

  <link rel="shortcut icon" href="{{ public_path('img/favicon.png') }}" type="image/x-icon">
  <link rel="icon" href="{{ public_path('img/favicon.png') }}" type="image/x-icon">
  <link href="{{ public_path('img/favicon.png') }}" rel="apple-touch-icon">
  
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <link href="{{ public_path('css/style.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ public_path('css/preloader.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ public_path('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

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

    <div style="margin-top: 7rem">
        <div class="title text-center mb-5" >Código de cliente - <b>{{ $cliente->codigoCliente }}</b></div>
    </div>
    
    <div class="row mb-3" style="font-size: 15px;">
        <div class="alert alert-primary d-flex align-items-center l-bg-primary mt-2" role="alert">
            <div style="margin-top: -10px !important;">
                <b>Información del cliente</b>
            </div>
        </div>

        <div class="col-md-6 col-12">
            <div class="subtitle"><b>Fecha de nacimiento:</b> {{ \Carbon\Carbon::parse($cliente->fecha_nac)->formatLocalized('%d de %B de %Y') }}</div>
        </div>
        <div class="col-md-6 col-12">
            <div class="subtitle"><b>Nacionalidad:</b> {{ $cliente->nacionalidad }}</div>
        </div>

        <div class="col-md-6 col-12">
            <div class="subtitle"><b>Dirección:</b> {{ $cliente->direccion }}</div>
        </div>
        <div class="col-md-6 col-12">
            <div class="subtitle"><b>Colonia:</b> {{ $cliente->colonia }}</div>
        </div>

        <div class="col-md-6 col-12">
            <div class="subtitle"><b>Código postal:</b> {{ $cliente->cp }}</div>
        </div>
        <div class="col-md-6 col-12">
            <div class="subtitle"><b>Ciudad:</b> {{ $cliente->ciudad }}</div>
        </div>

        <div class="col-md-6 col-12">
            <div class="subtitle"><b>Estado:</b> {{ $cliente->estado }}</div>
        </div>
        <div class="col-md-6 col-12">
            <div class="subtitle"><b>Celular:</b> {{ $cliente->celular }}</div>
        </div>

        <div class="col-md-6 col-12">
            <div class="subtitle"><b>Email personal:</b> {{ $cliente->correo_personal }}</div>
        </div>
        <div class="col-md-6 col-12">
            <div class="subtitle"><b>Email institucional:</b> {{ $cliente->correo_institucional }}</div>
        </div>

        <div class="col-md-6 col-12">
            <div class="subtitle"><b>INE:</b>             
                @if (strlen($cliente->ine) > 0)
                    {{ $cliente->ine }}
                @else
                    <span class="badge bg-danger text-white pt-0" style="margin-bottom: -6px !important">No tiene INE</span>
                @endif
            </div>
        </div>
        <div class="col-md-6 col-12">
            <div class="subtitle"><b>¿Tiene tarjeta?:</b> 
                @if ($cliente->tarjeta == "SI")
                    <span class="badge bg-success text-white pt-0" style="margin-bottom: -6px !important">{{ $cliente->tarjeta }}</span>
                @else
                    <span class="badge bg-danger text-white pt-0" style="margin-bottom: -6px !important">{{ $cliente->tarjeta }}</span>
                @endif
                
            </div>
        </div>

        <div class="col-md-6 col-12">
            <div class="subtitle"><b>Pasaporte:</b>
                @if (strlen($cliente->pasaporte) > 0)
                    {{ $cliente->pasaporte }}
                @else
                    <span class="badge bg-danger text-white pt-0" style="margin-bottom: -6px !important">No tiene pasaporte</span>
                @endif
            </div>
        </div>
        <div class="col-md-6 col-12">
            <div class="subtitle"><b>Fecha de vencimiento:</b> {{ \Carbon\Carbon::parse($cliente->vencimiento_pasaporte)->formatLocalized('%d de %B de %Y') }}</div>
        </div>

        <div class="col-md-6 col-12">
            <div class="subtitle"><b>Cuenta IBAN:</b>
                @if (strlen($cliente->iban) > 2)
                    {{ $cliente->iban }}
                @else
                    <span class="badge bg-warning text-white pt-0" style="margin-bottom: -6px !important">No tiene cuenta IBAN</span>
                @endif
            </div>
        </div>
        <div class="col-md-6 col-12">
            <div class="subtitle"><b>Cuenta Swift:</b>
                @if ($cliente->swift != "SWQBCHZZXXX" && strlen($cliente->swift) > 0)
                    {{ $cliente->swift }}
                @else
                    <span class="badge bg-warning text-white pt-0" style="margin-bottom: -6px !important">No tiene cuenta Swift</span>
                @endif
            </div>
        </div>
    </div>

    <div class="row mb-3" style="font-size: 15px; page-break-inside: avoid !important;">
        <div class="alert alert-primary d-flex align-items-center l-bg-primary mt-2" role="alert">
            <div style="margin-top: -10px !important;">
                <b>Contratos y convenios</b>
            </div>
        </div>

        @if (sizeof($contratos_men_tot) > 0 || sizeof($contratos_comp_tot) > 0 || sizeof($convenio_tot) > 0)
            @foreach ($contratos_men_tot as $contrato)
                @php
                    $pago = str_pad($contrato->serie, 2, "0", STR_PAD_LEFT).'/12';
                @endphp
                <div class="col-md-6 col-12" style="margin-bottom: -2rem !important;">
                    <div class="subtitle" style="margin-bottom: -1rem !important;"><b>Contrato mensual:</b> {{$contrato->contrato}} <i>(pago {{ $pago }}).</i></div>
                    <div class="subtitle"><b>Invertido:</b> <i><u>${{ number_format($contrato->inversion, 2) }} MXN. (${{ number_format($contrato->inversion_us, 2) }} dólares).</u></i></div>
                    <br />
                </div>
            @endforeach
            @foreach ($contratos_comp_tot as $contrato)
                <div class="col-md-6 col-12" style="margin-bottom: -2rem !important;">
                    <div class="subtitle" style="margin-bottom: -1rem !important;"><b>Contrato compuesto:</b> {{$contrato->contrato}} <i>({{ \Carbon\Carbon::parse($contrato->fecha_pago)->format('d/m/Y') }}).</i></div>
                    <div class="subtitle"><b>Invertido:</b> <i><u>${{ number_format($contrato->inversion, 2) }} MXN. (${{ number_format($contrato->inversion_us, 2) }} dólares).</u></i></div>
                    <br />
                </div>
            @endforeach
            @foreach ($convenio_tot as $convenio)
                <div class="col-md-6 col-12" style="margin-bottom: -2rem !important;">
                    <div class="subtitle" style="margin-bottom: -1rem !important;"><b>Convenio:</b> {{$convenio->folio}}.</div>
                    <div class="subtitle"><b>Invertido:</b> <i><u>${{ number_format($convenio->monto*19.5, 2) }} MXN. (${{ number_format($convenio->monto, 2) }} dólares).</u></i></div>
                    <br />
                </div>
            @endforeach
        @else
            <div class="col-md-12 text-center">
                <div class="subtitle text-center"><b>No se ha registrado ningún contrato o convenio...</b></div>
            </div>
        @endif
    </div>

    <div class="row mt-5" style="font-size: 15px; page-break-inside: avoid !important;">
        <div class="alert alert-primary d-flex align-items-center l-bg-primary mt-2" role="alert">
            <div style="margin-top: -10px !important;">
                <b>Suma de convenios y contratos e inversión total</b>
            </div>
        </div>

        <div>
            <div class="contenedor_firma__izquierda text-center">
                <div class="subtitle"><b>Convenios:</b> {{ $convenios }}</div>
            </div>
            <div class="contenedor_firma__derecha text-center">
                <div class="subtitle"><b>Contratos mensuales:</b> {{ $contrato_mensual }}</div>
            </div>
        </div>

        <div class="mt-4">
            <div class="contenedor_firma__izquierda text-center">
                <div class="subtitle"><b>Contratos compuestos:</b> {{ $contrato_compuesto }}</div>
            </div>
            <div class="contenedor_firma__derecha text-center">
                <div class="subtitle"><b>Total de contratos:</b> {{ $contratos }}</div>
            </div>
        </div>

        <div class="mt-1">                    
            <div class="col-md-12 text-center" style="margin-bottom: -0.5rem !important;">
                <div class="subtitle"><b>Inversión total en contrato mensual:</b> ${{ number_format($contratos_inv_mens, 2) }} MXN. (${{ number_format($contratos_inv_dol_mens, 2) }} dólares)</div>
            </div>
        
            <div class="col-md-12 text-center" style="margin-bottom: -0.5rem !important;">
                <div class="subtitle"><b>Inversión total en contrato compuesto:</b> ${{ number_format($contratos_inv_comp, 2) }} MXN. (${{ number_format($contratos_inv_dol_comp, 2) }} dólares)</div>
            </div>
            
            <div class="col-md-12 text-center" style="margin-bottom: -0.5rem !important;">
                <div class="subtitle"><b>Inversión total en convenios:</b> ${{ number_format($convenios_monto, 2) }} MXN. (${{ number_format($convenios_monto_dol, 2) }} dólares)</div>
            </div>
        
            <div class="col-md-12 text-center" style="margin-bottom: -0.5rem !important;">
                <div class="subtitle"><b>Inversión total final:</b> ${{ number_format($total_pesos, 2) }} (${{ number_format($total_dolares, 2) }} dólares)</div>
            </div>
        </div>
    </div>
</body>

</html>