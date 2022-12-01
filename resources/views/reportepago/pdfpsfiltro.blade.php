@extends('reportepago.imprimir')

@section('title', 'VISTA PREVIA')



@section('content')
<img class="imgUP_superior" src="{{ public_path('img/logo_sup.png') }}" alt="Logo uptrading">

<img class="imgUP_centro" src="{{ public_path('img/logo_centro.png') }}" alt="">

{{-- <img class="imgUP_inferior" src="{{ public_path('img/logo_latam.png') }}" alt="Logo uptrading"> --}}

@php
$fechadesde = \Carbon\Carbon::parse($fechadesde);
$fechadesde = $fechadesde->toDateString();

$fechahasta = \Carbon\Carbon::parse($fechahasta);
$fechahasta = $fechahasta->toDateString();

$fecha_texto_primer = \Carbon\Carbon::parse(strtotime($fechadesde))->formatLocalized('%d de %B de %Y');
$fecha_texto_ultimo = \Carbon\Carbon::parse(strtotime($fechahasta))->formatLocalized('%d de %B de %Y');

$totalPeriodo = DB::table("pago_ps")
->select(DB::raw("SUM(pago) AS totalPeriodo"))
->where("pago_ps.fecha_pago", ">=", $fechadesde)
->where("pago_ps.fecha_pago", "<=", $fechahasta) ->get();
    @endphp

    <p class="contrato_parrafo text-uppercase" style="font-weight: bold; text-align: right; margin-bottom: 0;">Total en
        el
        periodo: $@convert($totalPeriodo[0]->totalPeriodo) </p>
    <p class="contrato_parrafo text-uppercase"
        style="font-weight: bold; text-align: right; margin-bottom: 0; margin-top: 0;">Fecha de emisión: {{
        date("d/m/Y") }}
    </p>

    <div class="contenedor_imprimir_contrato2 w-100">
        <p class="mb-3 contrato_parrafo text-center mt-5" style="font-weight: bold; text-transform: uppercase;">Reporte
            de pagos a PS desde el {{ $fecha_texto_primer }} hasta el {{ $fecha_texto_ultimo }} ({{ $fechadesde }} - {{ $fechahasta }})</p>

        @php
        $fechadesde = date("Y-m-d", strtotime($fechadesde));
        $fechahasta = date("Y-m-d", strtotime($fechahasta));

        $pagosPS = DB::table("pago_ps")
        ->join('contrato', 'contrato.id', '=', 'pago_ps.contrato_id')
        ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
        ->join('ps', 'ps.id', '=', 'contrato.ps_id')
        ->select(DB::raw("contrato.contrato AS contrato, pago_ps.id, pago_ps.contrato_id AS contratoid, pago_ps.serie,
        pago_ps.fecha_pago, pago_ps.pago, pago_ps.status, pago_ps.memo, pago_ps.tipo_pago, pago_ps.comprobante,
        CONCAT(cliente.nombre, ' ', cliente.apellido_p,
        ' ', cliente.apellido_m) AS cliente_nombre, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS
        ps_nombre"))
        ->where("pago_ps.fecha_pago", ">=", $fechadesde)
        ->where("pago_ps.fecha_pago", "<=", $fechahasta) ->get();

            $totEfectivo = DB::table("pago_ps")
            ->select(DB::raw("SUM(pago) AS totalEfectivo"))
            ->where("pago_ps.fecha_pago", ">=", $fechadesde)
            ->where("pago_ps.fecha_pago", "<=", $fechahasta) ->where("pago_ps.tipo_pago", "=", 'Efectivo')
                ->get();

                $totSwiss = DB::table("pago_ps")
                ->select(DB::raw("SUM(pago) AS totalSwiss"))
                ->where("pago_ps.fecha_pago", ">=", $fechadesde)
                ->where("pago_ps.fecha_pago", "<=", $fechahasta) ->where("pago_ps.tipo_pago", "=", 'Transferencia
                    Swissquote a POOL')
                    ->get();

                    $totMX = DB::table("pago_ps")
                    ->select(DB::raw("SUM(pago) AS totalMX"))
                    ->where("pago_ps.fecha_pago", ">=", $fechadesde)
                    ->where("pago_ps.fecha_pago", "<=", $fechahasta) ->where("pago_ps.tipo_pago", "=", 'Transferencia MX
                        a POOL')
                        ->get();

                        $totHSBC = DB::table("pago_ps")
                    ->select(DB::raw("SUM(pago) AS totalHSBC"))
                    ->where("pago_ps.fecha_pago", ">=", $fechadesde)
                    ->where("pago_ps.fecha_pago", "<=", $fechahasta) ->where("pago_ps.tipo_pago", "=", 'Transferencia HSBC
                        a POOL')
                        ->get();
                        @endphp
                        

                        <table
                            class="tabla_reverso table table-sm table-striped table-bordered border-secondary w-100 rounded">
                            <thead class="p-1">
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th colspan="2" style="background-color: #70c9d1">Monto de entradas</th>
                                    <th>$@convert($totEfectivo[0]->totalEfectivo)</th>
                                    <th>$@convert($totSwiss[0]->totalSwiss)</th>
                                    <th>$@convert($totMX[0]->totalMX)</th>
                                    <th>$@convert($totHSBC[0]->totalHSBC)</th>
                                </tr>
                            </thead>
                            <thead>
                                <tr style="background-color: #70c9d1">
                                    <th class="align-middle" style="">#</th>
                                    <th class="align-middle" style="">Contrato</th>
                                    <th class="align-middle">Fecha</th>
                                    <th class="align-middle" style="">Cliente</th>
                                    <th class="align-middle">PS</th>
                                    <th class="align-middle">Efectivo</th>
                                    <th class="align-middle">Transferencia de Swissquote a POOL</th>
                                    <th class="align-middle">Transferencia directa MX a POOL</th>
                                    <th class="align-middle">Transferencia HSBC</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i = 1
                                @endphp
                                @foreach ($pagosPS as $pagoPS)
                                <tr>
                                    <td class="align-middle">{{ $i }}</td>
                                    <td class="align-middle">{{ $pagoPS->contrato }}</td>
                                    <td class="align-middle">{{ $pagoPS->fecha_pago }}</td>
                                    <td class="align-middle">{{ $pagoPS->cliente_nombre }}</td>
                                    <td class="align-middle">{{ $pagoPS->ps_nombre }}</td>
                                    @if ($pagoPS->tipo_pago == 'Pendiente')
                                    <td colspan="4" class="align-middle">Tipo de pago Pendiente:
                                        $@convert($pagoPS->pago)
                                    </td>
                                    @else
                                    @if ($pagoPS->tipo_pago == "Efectivo")
                                    <td class="align-middle">$@convert($pagoPS->pago)</td>
                                    @else
                                    <td class="align-middle"></td>
                                    @endif
                                    @if ($pagoPS->tipo_pago == "Transferencia Swissquote a POOL")
                                    <td class="align-middle">$@convert($pagoPS->pago)</td>
                                    @else
                                    <td class="align-middle"></td>
                                    @endif
                                    @if ($pagoPS->tipo_pago == "Transferencia MX a POOL")
                                    <td class="align-middle">$@convert($pagoPS->pago)</td>
                                    @else
                                    <td class="align-middle"></td>
                                    @endif
                                    @if ($pagoPS->tipo_pago == "Transferencia HSBC")
                                    <td class="align-middle">$@convert($pagoPS->pago)</td>
                                    @else
                                    <td class="align-middle"></td>
                                    @endif
                                    @endif
                                </tr>
                                @php
                                $i++;
                                @endphp
                                @endforeach
                            </tbody>
                        </table>
    </div>
    @endsection