@extends('amortizacion.imprimir')

@section('title', 'PAGOS A CLIENTES')

@section('content')
<img class="imgUP_superior" src="{{ public_path('img/logo_sup.png') }}" alt="Logo uptrading">

<img class="imgUP_centro" src="{{ public_path('img/logo_centro.png') }}" alt="">

<img class="imgUP_inferior" src="{{ public_path('img/logo_latam.png') }}" alt="Logo uptrading">

<div class="contenedor_imprimir_contrato2 mt-5 pt-4">
    
    <p class="mb-3 contrato_parrafo text-right" style="font-size: 12px;">Victoria de Durango, Durango a 22 de Agosto de 2022.</p>
      
    <p class="contrato_parrafo" style="font-size: 12px;"><span style="margin-left: 40px;">Yo</span>, <span style="text-transform: lowercase;">{{ $amortizaciones->cliente_nombre }}</span>, recibo la cantidad de $50,000.00 M.N. (son cincuenta mil pesos 00/100 M.N.), por concepto de pago de rendimiento del día 22 de agosto con relación al contrato {{ $amortizaciones->contrato }}, sin que al momento exista algún adeudo.</p>

</div>
@endsection