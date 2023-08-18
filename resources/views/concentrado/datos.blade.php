<div class="title text-center">Código de cliente - <b>{{ $cliente->codigoCliente }}</b></div>
<div class="text-center mb-4">
    <a href='{{ url("/admin/reporteConcentrado?id=$cliente->id&dolar=$dolar") }}' target="_blank" class="btn principal-button">Imprimir concentrado</a>
</div>
<div class="row mb-3" style="font-size: 15px;">
    <div class="alert alert-primary d-flex align-items-center l-bg-primary mt-2" role="alert">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
            <use xlink:href="#info-fill"></use>
        </svg>
        <div>
            Información del cliente
        </div>
    </div>

    <div class="col-md-6 col-12 mb-1">
        <div class="subtitle"><b>Fecha de nacimiento:</b> {{ \Carbon\Carbon::parse($cliente->fecha_nac)->formatLocalized('%d de %B de %Y') }}</div>
    </div>
    <div class="col-md-6 col-12 mb-1">
        <div class="subtitle"><b>Nacionalidad:</b> {{ $cliente->nacionalidad }}</div>
    </div>

    <div class="col-md-6 col-12 mb-1">
        <div class="subtitle"><b>Dirección:</b> {{ $cliente->direccion }}</div>
    </div>
    <div class="col-md-6 col-12 mb-1">
        <div class="subtitle"><b>Colonia:</b> {{ $cliente->colonia }}</div>
    </div>

    <div class="col-md-6 col-12 mb-1">
        <div class="subtitle"><b>Código postal:</b> {{ $cliente->cp }}</div>
    </div>
    <div class="col-md-6 col-12 mb-1">
        <div class="subtitle"><b>Ciudad:</b> {{ $cliente->ciudad }}</div>
    </div>
    
    <div class="col-md-6 col-12 mb-1">
        <div class="subtitle"><b>Estado:</b> {{ $cliente->estado }}</div>
    </div>
    <div class="col-md-6 col-12 mb-1">
        <div class="subtitle"><b>Celular:</b> {{ $cliente->celular }}</div>
    </div>

    <div class="col-md-6 col-12 mb-1">
        <div class="subtitle"><b>Email personal:</b> {{ $cliente->correo_personal }}</div>
    </div>
    <div class="col-md-6 col-12 mb-1">
        <div class="subtitle"><b>Email institucional:</b> {{ $cliente->correo_institucional }}</div>
    </div>

    <div class="col-md-6 col-12 mb-1">
        <div class="subtitle"><b>INE:</b>             
            @if (strlen($cliente->ine) > 0)
                {{ $cliente->ine }}
            @else
                <span class="badge bg-danger">No tiene INE</span>
            @endif
        </div>
    </div>
    <div class="col-md-6 col-12 mb-1">
        <div class="subtitle"><b>¿Tiene tarjeta?:</b> 
            @if ($cliente->tarjeta == "SI")
                <span class="badge bg-success">{{ $cliente->tarjeta }}</span>
            @else
                <span class="badge bg-danger">{{ $cliente->tarjeta }}</span>
            @endif
            
        </div>
    </div>
    
    <div class="col-md-6 col-12 mb-1">
        <div class="subtitle"><b>Pasaporte:</b>
            @if (strlen($cliente->pasaporte) > 0)
                {{ $cliente->pasaporte }}
            @else
                <span class="badge bg-danger">No tiene pasaporte</span>
            @endif
        </div>
    </div>
    <div class="col-md-6 col-12 mb-1">
        <div class="subtitle"><b>Fecha de vencimiento:</b> {{ \Carbon\Carbon::parse($cliente->vencimiento_pasaporte)->formatLocalized('%d de %B de %Y') }}</div>
    </div>

    <div class="col-md-6 col-12">
        <div class="subtitle"><b>Cuenta IBAN:</b>
            @if (strlen($cliente->iban) > 2)
                {{ $cliente->iban }}
            @else
                <span class="badge bg-warning">No tiene cuenta IBAN</span>
            @endif
        </div>
    </div>
    <div class="col-md-6 col-12">
        <div class="subtitle"><b>Cuenta Swift:</b>
            @if ($cliente->swift != "SWQBCHZZXXX" && strlen($cliente->swift) > 0)
                {{ $cliente->swift }}
            @else
                <span class="badge bg-warning">No tiene cuenta Swift</span>
            @endif
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="alert alert-primary d-flex align-items-center l-bg-primary mt-2" role="alert">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
            <use xlink:href="#info-fill"></use>
        </svg>
        <div>
            Contratos y convenios
        </div>
    </div>

    @if (sizeof($contratos_men_tot) > 0 || sizeof($contratos_comp_tot) > 0 || sizeof($convenio_tot) > 0)
        @foreach ($contratos_men_tot as $contrato)
            @php
                $pago = str_pad($contrato->serie, 2, "0", STR_PAD_LEFT).'/12';
            @endphp
            <div class="col-md-6 col-12">
                <div class="subtitle"><b>Contrato mensual:</b> {{$contrato->contrato}} <i>(pago {{ $pago }}).</i></div>
                @if($contrato->moneda == "dolares")
                    <div class="subtitle"><b>Invertido:</b> <i><u>${{ number_format($contrato->inversion, 2) }} MXN. (${{ number_format($contrato->inversion_us, 2) }} dólares).</u></i></div>
                    <br />
                @elseif($contrato->moneda == "euros")
                    <div class="subtitle"><b>Invertido:</b> <i><u>${{ number_format($contrato->inversion, 2) }} MXN. (${{ number_format($contrato->inversion_eur, 2) }} euros).</u></i></div>
                    <br />
                @elseif($contrato->moneda == "francos")
                    <div class="subtitle"><b>Invertido:</b> <i><u>${{ number_format($contrato->inversion, 2) }} MXN. (${{ number_format($contrato->inversion_chf, 2) }} francos suizos).</u></i></div>
                    <br />
                @endif
            </div>
        @endforeach
        @foreach ($contratos_comp_tot as $contrato)
            <div class="col-md-6 col-12">
                <div class="subtitle"><b>Contrato compuesto:</b> {{$contrato->contrato}} <i>({{ \Carbon\Carbon::parse($contrato->fecha_pago)->format('d/m/Y') }}).</i></div>
                @if($contrato->moneda == "dolares")
                    <div class="subtitle"><b>Invertido:</b> <i><u>${{ number_format($contrato->inversion, 2) }} MXN. (${{ number_format($contrato->inversion_us, 2) }} dólares).</u></i></div>
                    <br />
                @elseif($contrato->moneda == "euros")
                    <div class="subtitle"><b>Invertido:</b> <i><u>${{ number_format($contrato->inversion, 2) }} MXN. (${{ number_format($contrato->inversion_eur, 2) }} euros).</u></i></div>
                    <br />
                @elseif($contrato->moneda == "francos")
                    <div class="subtitle"><b>Invertido:</b> <i><u>${{ number_format($contrato->inversion, 2) }} MXN. (${{ number_format($contrato->inversion_chf, 2) }} francos suizos).</u></i></div>
                    <br />
                @endif
            </div>
        @endforeach
        @foreach ($convenio_tot as $convenio)
            <div class="col-md-6 col-12">
                <div class="subtitle"><b>Convenio:</b> {{$convenio->folio}}.</div>
                <div class="subtitle"><b>Invertido:</b> <i><u>${{ number_format($convenio->monto * $dolar, 2) }} MXN. (${{ number_format($convenio->monto, 2) }} dólares).</u></i></div>
                <br />
            </div>
        @endforeach
    @else
        <div class="col-md-12 text-center">
            <div class="subtitle text-center"><b>No se ha registrado ningún contrato o convenio...</b></div>
        </div>        
    @endif
</div>                        

<div class="row">
    <div class="alert alert-primary d-flex align-items-center l-bg-primary mt-2" role="alert">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
            <use xlink:href="#info-fill"></use>
        </svg>
        <div>
            Suma de convenios y contratos e inversión total
        </div>
    </div>

    <div class="col-md-6 col-12 mb-2 text-center">
        <div class="subtitle"><b>Convenios:</b> {{ $convenios }}</div>
    </div>

    <div class="col-md-6 col-12 mb-2 text-center">
        <div class="subtitle"><b>Contratos mensuales:</b> {{ $contrato_mensual }}</div>
    </div>

    <div class="col-md-6 col-12 mb-2 text-center">
        <div class="subtitle"><b>Contratos compuestos:</b> {{ $contrato_compuesto }}</div>
    </div>                            

    <div class="col-md-6 col-12 mb-3 text-center">
        <div class="subtitle"><b>Total de contratos:</b> {{ $contratos }}</div>
    </div>

    <div class="col-md-12 mb-2 text-center">
        <div class="subtitle"><b>Total convenios:</b> ${{ number_format($convenios_monto, 2) }} MXN. (${{ number_format($convenios_monto_dol, 2) }} dólares)</div>
    </div>

    <div class="col-md-12 mb-2 text-center">
        <div class="subtitle"><b>Total mensual:</b> ${{ number_format($contratos_inv_mens, 2) }} MXN. (${{ number_format($contratos_inv_dol_mens, 2) }} dólares, ${{ number_format($contratos_inv_eur_mens, 2) }} euros, ${{ number_format($contratos_inv_chf_mens, 2) }} francos)</div>
    </div>

    <div class="col-md-12 mb-2 text-center">
        <div class="subtitle"><b>Total compuesto:</b> ${{ number_format($contratos_inv_comp, 2) }} MXN. (${{ number_format($contratos_inv_dol_comp, 2) }} dólares, ${{ number_format($contratos_inv_eur_comp, 2) }} euros, ${{ number_format($contratos_inv_chf_comp, 2) }} francos)</div>
    </div>

    <div class="col-md-12 text-center">
        <div class="subtitle"><b>Total final:</b> ${{ number_format($total_pesos, 2) }} (${{ number_format($total_dolares, 2) }} dólares, ${{ number_format($total_euros, 2) }} euros, ${{ number_format($total_francos, 2) }} francos)</div>
    </div>
</div>