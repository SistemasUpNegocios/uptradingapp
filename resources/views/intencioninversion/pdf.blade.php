@php
$query = App\Models\IntencionInversion::where('id', $id)->get();
$nombre = $query[0]->nombre;
$telefono = $query[0]->telefono;
$email = $query[0]->email;
$tipo_cambio = $query[0]->tipo_cambio;
$inversion = $query[0]->inversion_mxn;
$inversion_us = $query[0]->inversion_usd;
$tipo_contrato = $query[0]->tipo_1;
$tipo_contrato2 = $query[0]->tipo_2;
$fecha_inicio = $query[0]->fecha_inicio;
$folio = $query[0]->id;

$porcentaje = $query[0]->porcentaje_inversion_1;
$porcentaje2 = $query[0]->porcentaje_inversion_2;

$inversionUSD1 = $query[0]->inversion_usd;
$rendimiento = $query[0]->porcentaje_tipo_1;
$inversionUSD1 = $inversionUSD1 * ($porcentaje * 0.01);

$inversionUSD2 = $query[0]->inversion_usd;
$rendimiento2 = $query[0]->porcentaje_tipo_2;
$inversionUSD2 = $inversionUSD2 * ($porcentaje2 * 0.01);

@endphp

@extends('intencioninversion.imprimir')

@section('title', 'VISTA PREVIA')

@section('content')
<img class="imgUP_superior" src="{{ public_path('img/logo_sup.png') }}" alt="Logo uptrading">

<img class="imgUP_centro" src="{{ public_path('img/logo_centro.png') }}" alt="">

<img class="imgUP_inferior" src="{{ public_path('img/logo_latam.png') }}" alt="Logo uptrading">

<img class="imgUP_inferior_izq" src="{{ public_path('img/qr_pagina.png') }}" alt="Logo uptrading">

<p class="contrato_parrafo text-uppercase" style="font-weight: bold; text-align: right; margin-bottom: 0;">Folio no: {{
  $folio }}</p>

<p class="contrato_parrafo text-uppercase" style="font-weight: bold; text-align: right; margin-bottom: 0;">Nombre de
  inversor: {{ $nombre }}</p>

<p class="contrato_parrafo text-uppercase" style="font-weight: bold; text-align: right; margin-bottom: 0;">Email: {{
  $email }}</p>
<p class="contrato_parrafo text-uppercase" style="font-weight: bold; text-align: right; margin-bottom: 0;">Teléfono: {{
  $telefono }}</p>

<p class="contrato_parrafo text-uppercase"
  style="font-weight: bold; text-align: right; margin-bottom: 0; margin-top: 0;">Fecha de emisión: {{ date("d/m/Y") }}
</p>
<p class="contrato_parrafo text-uppercase"
  style="font-weight: bold; text-align: right; margin-bottom: 0; margin-top: 0;">Tipo de cambio: $@convert($tipo_cambio)
</p>

@if ($tipo_contrato2 == null)
<div class="contenedor_imprimir_contrato2" style="margin-top: 8rem">
  @else
  <div class="contenedor_imprimir_contrato2">
    @endif
    <p class="mb-3 contrato_parrafo text-center" style="font-weight: bold; margin-top: 0">REPORTE DE INTENCIÓN DE
      INVERSIÓN</p>
    <table class="table table-striped table-bordered table-sm text-center tabla_reverso"
      style="font-size: 11px; margin-bottom: 0.5rem;">
      <thead>
        <tr>
          <th style="background-color: rgb(220, 220, 220)" scope="col">INVERSIÓN EN MXN</th>
          <th style="background-color: rgb(180, 180, 180)" scope="col">$@convert($inversion)</th>
          <th style="background-color: rgb(220, 220, 220)" scope="col">INVERSIÓN EN USD</th>
          <th style="background-color: rgb(180, 180, 180)" scope="col">$@convert($inversion_us)</th>
        </tr>
      </thead>
    </table>
    @if ($tipo_contrato2 == null)
    @php
    $inversionUSD1 = $inversion_us;
    @endphp
    <p class="mb-3 contrato_parrafo text-center text-uppercase">INTENCIÓN DE INVERSIÓN {{
      $tipo_contrato }}</p>
    @else
    <p class="mb-3 contrato_parrafo text-center text-uppercase" style="font-weight: bold">INTENCIÓN DE INVERSIÓN {{
      $tipo_contrato }} con el {{ $porcentaje }}% de la inversión total ($@convert($inversionUSD1) USD)</p>
    @endif

    @if ($tipo_contrato == "Rendimiento mensual")
    <div class="contenedor_tabla">
      <table class="tabla_reverso table table-sm">
        <thead>
          <tr>
            <th style="color: #85586F">FECHA DE CORTE</th>
            <th style="background: #e4ffdf">CAPITAL (USD)</th>
            <th style="color: #85586F">INTERÉS</th>
          </tr>
        </thead>
        <tbody>
          @php
          $cobrado = 0;
          @endphp
          @for ($i = 1; $i < 13; $i++) <tr>
            <td style="color: #85586F">{{\Carbon\Carbon::parse($fecha_inicio)->addMonths($i)->format('d/m/Y') }}</td>
            <td style="background: #e4ffdf">$@convert($inversionUSD1)</td>
            <td style="color: #85586F">$@convert($inversionUSD1 * ($rendimiento * .01))</td>
            </tr>
            @php
            $cobrado += ($inversionUSD1 * ($rendimiento * .01));
            @endphp
            @endfor
            <tr style="background: #4CACBC; color: #fff">
              <th colspan="2">COBRADO</th>
              <th>$@convert($cobrado)</td>
            </tr>
            <tr style="background: #1363DF; color: #fff">
              <th colspan="2">CAPITAL</th>
              <th>$@convert($inversionUSD1)</th>
            </tr>
            <tr style="background: #06283D; color: #fff">
              <th colspan="2">BENEFICIO TOTAL</th>
              <th>$@convert($cobrado + $inversionUSD1)</th>
            </tr>
        </tbody>
      </table>
    </div>
    @elseif ($tipo_contrato == "Rendimiento compuesto")
    <div class="contenedor_tabla">
      <table class="tabla_reverso table table-sm">
        <thead>
          <tr>
            <th style="color: #85586F">FECHA</th>
            <th style="background: #d9e1f2">CAPITAL (USD)</th>
            <th style="color: #85586F">INTERÉS</th>
          </tr>
        </thead>
        <tbody>
          @php
          $acumulado = 0;
          $acumulado_capital = $inversionUSD1;
          $acumulado_interes = $inversionUSD1 * ($rendimiento * .01);
          @endphp
          @for ($i = 1; $i < 13; $i++) <tr>
            <td style="color: #85586F">{{\Carbon\Carbon::parse($fecha_inicio)->addMonths($i)->format('d/m/Y') }}</td>
            <td style="background: #d9e1f2">$@convert($acumulado_capital += $acumulado_interes)</td>
            @if ($i == 1)
            <td style="color: #85586F">$@convert($inversionUSD1 * ($rendimiento * .01))</td>
            @else
            <td style="color: #85586F">$@convert($acumulado_interes += ($acumulado_interes * ($rendimiento * .01)))</td>
            @endif
            </tr>
            @php
            $acumulado += ($acumulado_interes)
            @endphp
            @endfor
            <tr style="background: #4CACBC; color: #fff">
              <th colspan="2">ACUMULADO</th>
              <th>$@convert($acumulado)</th>
            </tr>
            <tr style="background: #1363DF; color: #fff">
              <th colspan="2">CAPITAL</th>
              <th>$@convert($inversionUSD1)</th>
            </tr>
            <tr style="background: #06283D; color: #fff">
              <th colspan="2">BENEFICIO TOTAL</th>
              <th>$@convert($acumulado + $inversionUSD1)</th>
            </tr>
        </tbody>
      </table>
    </div>
    @endif

    @if ($tipo_contrato2 != null)
    <p class="mb-3 contrato_parrafo text-center text-uppercase" style="font-weight: bold">INTENCIÓN DE INVERSIÓN {{
      $tipo_contrato2 }} con el {{ $porcentaje2 }}% de la inversión total ($@convert($inversionUSD2) USD)</p>
    @if ($tipo_contrato2 == "Rendimiento mensual")
    <div class="contenedor_tabla mb-0">
      <table class="tabla_reverso table table-sm">
        <thead>
          <tr>
            <th style="color: #85586F">FECHA DE CORTE</th>
            <th style="background: #e4ffdf">CAPITAL (USD)</th>
            <th style="color: #85586F">INTERÉS</th>
          </tr>
        </thead>
        <tbody>
          @php
          $cobrado = 0;
          @endphp
          @for ($i = 1; $i < 13; $i++) <tr>
            <td style="color: #85586F">{{\Carbon\Carbon::parse($fecha_inicio)->addMonths($i)->format('d/m/Y') }}</td>
            <td style="background: #e4ffdf">$@convert($inversionUSD2 + ($inversionUSD2 * ($rendimiento2 * .01)))</td>
            <td style="color: #85586F">$@convert($inversionUSD2 * ($rendimiento2 * .01))</td>
            </tr>
            @php
            $cobrado += ($inversionUSD2 * ($rendimiento2 * .01));
            @endphp
            @endfor
            <tr style="background: #4CACBC; color: #fff">
              <th colspan="2">COBRADO</th>
              <th>$@convert($cobrado)</td>
            </tr>
            <tr style="background: #1363DF; color: #fff">
              <th colspan="2">CAPITAL</th>
              <th>$@convert($inversionUSD2)</th>
            </tr>
            <tr style="background: #06283D; color: #fff">
              <th colspan="2">BENEFICIO TOTAL</th>
              <th>$@convert($cobrado + $inversionUSD2)</th>
            </tr>
        </tbody>
      </table>
    </div>
    @elseif ($tipo_contrato2 == "Rendimiento compuesto")
    <div class="contenedor_tabla mb-0">
      <table class="tabla_reverso table table-sm">
        <thead>
          <tr>
            <th style="color: #85586F">FECHA</th>
            <th style="background: #d9e1f2">CAPITAL (USD)</th>
            <th style="color: #85586F">INTERÉS</th>
          </tr>
        </thead>
        <tbody>
          @php
          $acumulado = 0;
          $acumulado_capital = $inversionUSD2;
          $acumulado_interes = $inversionUSD2 * ($rendimiento2 * .01);
          @endphp
          @for ($i = 1; $i < 13; $i++) <tr>
            <td style="color: #85586F">{{\Carbon\Carbon::parse($fecha_inicio)->addMonths($i)->format('d/m/Y') }}</td>
            <td style="background: #d9e1f2">$@convert($acumulado_capital += $acumulado_interes)</td>
            @if ($i == 1)
            <td style="color: #85586F">$@convert($inversionUSD2 * ($rendimiento2 * .01))</td>
            @else
            <td style="color: #85586F">$@convert($acumulado_interes += ($acumulado_interes * ($rendimiento2 * .01)))
            </td>
            @endif
            </tr>
            @php
            $acumulado += ($acumulado_interes)
            @endphp
            @endfor
            <tr style="background: #4CACBC; color: #fff">
              <th colspan="2">ACUMULADO</th>
              <th>$@convert($acumulado)</th>
            </tr>
            <tr style="background: #1363DF; color: #fff">
              <th colspan="2">CAPITAL</th>
              <th>$@convert($inversionUSD2)</th>
            </tr>
            <tr style="background: #06283D; color: #fff">
              <th colspan="2">BENEFICIO TOTAL</th>
              <th>$@convert($acumulado + $inversionUSD2)</th>
            </tr>
        </tbody>
      </table>
    </div>
    @endif

    @endif

    <p class="mt-0 mb-0 contrato_parrafo" style="font-weight: bold">Esta proyección de intención de inversión se realiza
      en dólares, la conversión de pesos es meramente informativa y se realiza al tipo de cambio vigente, publicado por
      Banxico a la fecha de impresión del presente.</p>
  </div>
  @endsection