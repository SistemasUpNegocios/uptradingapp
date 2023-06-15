@extends('imprimir.imprimiranverso')

@section('title', 'VISTA PREVIA')

@php
    $tipo_id = $contratos[0]->modeloid;

    $query = DB::table('modelo_contrato')
    ->where('id', $tipo_id)
    ->first();

    $empresa = $query->empresa;
@endphp

{{-- Segunda versión  (dinamica) --}}
@section('content')
  <img class="imgUP_superior" src="{{ public_path('img/logo_sup.png') }}" alt="Logo uptrading">
  <img class="imgUP_centro" src="{{ public_path('img/logo_centro.png') }}" alt="Logo uptrading">
  <img class="imgUP_inferior" src="{{ public_path('img/logo_latam.png') }}" alt="Logo uptrading">  

  <div class="contenedor_imprimir_contrato">
    <p class="contrato_parrafo" style="font-weight: bold; text-align: right; margin-bottom: 0">CONTRATO: {{ $contratos[0]->contrato}}</p>
    <p class="mb-3 contrato_parrafo" style="font-weight: bold; text-align: right; margin-top: 0">FOLIO: {{ $contratos[0]->folio}}</p>
    <p class="mb-3 contrato_parrafo text-center" style="font-weight: bold">INVERSIÓN A LARGO PLAZO</p>
    <p class="mb-3 text-center" style="font-weight: bold; text-transform: uppercase; margin-top: -1rem; color: #000;">{{ $contratos[0]->tipocontrato }}</p>

    <p class="mb-3 contrato_parrafo">
        <span style="margin-left: 25px">Contrato</span> de inversión a largo plazo con <span style="text-transform: lowercase;">{{ $contratos[0]->tipocontrato }}</span>, celebrado por una parte por: <span style="text-transform: uppercase; font-weight: bold">{{ $contratos[0]->clientenombre }}</span> como "El Cliente" y {{ $empresa }} como "El Operador" de inversión. Con número de escritura 25518, volumen 1113 y fecha de 03 de junio del 2016. Representado por el Sr. Hilario Hamilton Herrera Cossaín.
    </span>

    <p class="mb-3 text-center" style="font-weight: bold; text-transform: uppercase; color: #000;">DECLARACIONES</p>

    <p class="mb-3 contrato_parrafo">
        I. "El Cliente" declara que cuenta con domicilio en: 
          <u style="text-transform: uppercase">{{$contratos[0]->clientedomicilio }} C.P. {{ $contratos[0]->codigopostal }},</u> se identifica con
          @if (strlen($contratos[0]->clienteine) > 0)
            INE
          @else
            PASAPORTE
          @endif
          <u>
            @if (strlen($contratos[0]->clienteine) > 0)
              {{ $contratos[0]->clienteine }}
            @else
              {{ $contratos[0]->clientepasaporte }}
            @endif
          </u>
        con número de celular <u>{{ $contratos[0]->clientecelular }}</u> y email <u>{{ $contratos[0]->clientecorreo }}</u>.
    </p>

    <p class="mb-3 contrato_parrafo">
        II. "El Operador" {{ $empresa }}, ubicada en Av. Universidad #234 Int. 308 con teléfono de oficina <span style="text-decoration: underline">8000878290</span> y con email
        <span style="text-decoration: underline">clientes@uptradingexperts.com</span>, declara que su representante legal es el Sr. Hilario Hamilton Herrera Cossaín con INE 0228061546388
    </p>

    <p class="mb-3 contrato_parrafo">
        III. Ambas partes declaran:
    </p>

      <ol type="A" class="center" style="color: #000">
          <li style="font-size: 10px">
              <p style="margin-bottom: -0.5rem">Ser mayores de edad y se identifican con credencial oficial con fotografía.</p>
          </li>
          <li style="font-size: 10px">
              <p style="margin-bottom: -0.5rem">Contar con capacidad legal para celebrar el presente acuerdo.</p>
          </li>
          <li style="font-size: 10px">
              <p style="margin-bottom: -0.5rem">Actuar de buena fé y por consentimiento propio.</p>
          </li>
          <li style="font-size: 10px">
              <p style="margin-bottom: -0.5rem">Contar con los recursos técnicos y económicos necesarios para cumplir con
                  el presente acuerdo.</p>
          </li>
          <li style="font-size: 10px">
              <p style="margin-bottom: -0.5rem; line-height: 11px">En atención al desarrollo de su actividad económica
                  principal, “El Cliente”, tiene recursos de procedencia lícita que destinará al prestador de servicio
                  para su administración con la finalidad de obtener un rendimiento de inversión, utilizando para ello
                  plataformas tecnológicas lícitas.
              </p>
          </li>
          <li style="font-size: 10px">
              <p style="margin-bottom: -0.5rem">Ambas partes reconocen los riesgos inherentes a cualquier proceso de
                  inversión.
              </p>
          </li>
          <li style="font-size: 10px">
              <p style="margin-bottom: -0.5rem">Se estima un rendimiento del <u>{{ str_replace("0.0","",
                  $contratos[0]->porcentaje) }}%</u> mensual sobre el capital de inversión.
                  Ratificando ambas partes estar de acuerdo.
              </p>
          </li>
          <li style="font-size: 10px">
              <p style="margin-bottom: -0.5rem; line-height: 11px">“El Cliente” confirma libertad de acción sobre la
                  inversión al proveedor de servicio. Ratificando estar de acuerdo con los criterios de selección en las
                  oportunidades de inversión.
              </p>
          </li>
          <li style="font-size: 10px">
              <p style="margin-bottom: -0.5rem; line-height: 11px">El inversionista confirma que cuenta con todas las
                  autorizaciones necesarias para celebrar el presente acuerdo y manifiesta que no le genera incumplimiento
                  a obligaciones previamente contraídas con terceros.
              </p>
          </li>
      </ol>

    <p class="mb-3 mt-2 text-center" style="font-weight: bold; text-transform: uppercase; color: #000;">CLÁUSULAS</p>

    @foreach ($clausulas as $clausula)
      <p class="mb-2 contrato_parrafo">
        @php
        $patrones = array();
        $sustituciones = array();

        $patrones[0] = '/{INVERSION_US}/';
        $patrones[1] = '/son {INVERSION_LETRA_US}/';
        $patrones[2] = '/{INVERSION}/';
        $patrones[3] = '/son {INVERSION_LETRA}/';
        $patrones[4] = '/{PERIODO}/';
        $patrones[5] = '/{RENDIMIENTO}/';
        $patrones[6] = '/{CENTAVOS_US}/';
        $patrones[7] = '/{CENTAVOS}/';
        $patrones[8] = '/{BENEFICIARIOS}/';
        $patrones[9] = '/{TIPO_CONTRATO}/';
        
        $sustituciones[0] = '<u>'.number_format($contratos[0]->inversion_us, 2).'</u>';
        $posILU = strrpos($contratos[0]->inversion_letra_us, "con");
        if($posILU === false){
          $sustituciones[1] = '<u>son '.$contratos[0]->inversion_letra_us;
        }else{
          $sustituciones[1] = '<u>son '.substr_replace($contratos[0]->inversion_letra_us, "", $posILU);
        }
        $sustituciones[2] = '<u>'.number_format($contratos[0]->inversion, 2).' M.N</u>';
        $posIL = strrpos($contratos[0]->inversion_letra, "con");
        if($posIL === false){
          $sustituciones[3] = '<u>son '.$contratos[0]->inversion_letra;
        }else{
          $sustituciones[3] = '<u>son '.substr_replace($contratos[0]->inversion_letra, "", $posIL);
        }        
        $sustituciones[4] = $contratos[0]->periodo;
        $sustituciones[5] = $contratos[0]->porcentaje;

        $moneyCentavos_us = strval($contratos[0]->inversion_us);
        $resultCentavos_us = explode(",", $moneyCentavos_us);

        if (next($resultCentavos_us)) {
          if (strlen($resultCentavos_us[1]) == 1) {
            $sustituciones[6] = substr($resultCentavos_us[1], 0, 2) . "0".'/100</u>';
          } else {
            $sustituciones[6] = substr($resultCentavos_us[1], 0, 2).'/100</u>';
          }
        } else {
          $sustituciones[6] = "00".'/100</u>';
        }

        $moneyCentavos = strval($contratos[0]->inversion);
        $resultCentavos = explode(",", $moneyCentavos);

        if (next($resultCentavos)) {
          if (strlen($resultCentavos[1]) == 1) {
            $sustituciones[7] = substr($resultCentavos[1], 0, 2) . "0".'/100 M.N</u>';
          } else {
            $sustituciones[7] = substr($resultCentavos[1], 0, 2).'/100 M.N</u>';
          }
        } else {
          $sustituciones[7] = "00".'/100 M.N</u>';
        }
        
        if (sizeof($beneficiarios) > 0) {
          $sustituciones[8] = "<div class='contenedor_beneficiarios'>
                  <div class='contenedor_beneficiarios_izquierda'>
                      <ol>
                        <p class='contrato_parrafo_li text-center'>Nombre</p>";
                          foreach($beneficiarios as $beneficiario){
                            if ($beneficiario->porcentaje > 0){
                              $sustituciones[8].="<li>$beneficiario->nombre</li>";
                            }
                          }
          $sustituciones[8].="</ol>
                  </div>
                  <div class='contenedor_beneficiarios_derecha'>
                    <ol>
                      <p class='contrato_parrafo_li text-center'>Porcentaje</p>";
                      foreach($beneficiarios as $beneficiario){
                        if ($beneficiario->porcentaje > 0){
                          $sustituciones[8].="<li>$beneficiario->porcentaje%</li>";
                        }
                      }
          $sustituciones[8].="</ol>
                  </div>
                </div>";
        } else {
          $sustituciones[8] = "<div>
              <ol>
                <p class='contrato_parrafo_li text-center'>Sin beneficiarios</p>
              </ol>
            </div>";
        }
        
        if ($contratos[0]->tipocontrato == "Rendimiento compuesto") {
          $sustituciones[9] = "<span style='text-decoration: underline;'>con interés compuesto</span>";
        } else if ($contratos[0]->tipocontrato == "Rendimiento mensual") {
          $sustituciones[9] = "<span style='text-decoration: underline;'>con interés mensual</span>";
        }
        
        echo preg_replace($patrones, $sustituciones, $clausula->redaccion);
      @endphp
      </p>
    @endforeach

    @if ($contratos[0]->tabla == true)
      @if ($contratos[0]->tipocontrato == 'Rendimiento mensual')
        <div class="contenedor_tabla">
          <table class="tabla_reverso table table-sm">
            <thead>
              <tr style="background: #66cbdc !important; color: #fff;">
                <th>FECHA DE CORTE</th>
                <th>CAPITAL (USD)</th>
                <th>INTERÉS</th>
              </tr>
            </thead>
            <tbody>
              @php
                  $cobrado_sum = 0;
              @endphp
              @foreach ($amortizaciones as $amortizacion)
              <tr>
                <td>{{date("d/m/Y", strtotime($amortizacion->fecha))}}</td>
                <td style="background: #00b0f02f !important">$@convert($amortizacion->monto)</td>
                <td>$@convert($amortizacion->redito)</td>
              </tr>
              @php
                  $cobrado_sum += $amortizacion->redito;
              @endphp
              @endforeach
              <tr style="background: #00b0f0 !important; color: #fff;">
                <th colspan="2">COBRADO</th>
                <th>$@convert($cobrado_sum)</td>
              </tr>
              <tr style="background: #0070c0 !important; color: #fff;">
                <th colspan="2">CAPITAL</th>
                <th>$@convert($contratos[0]->inversion_us)</th>
              </tr>
              <tr style="background: #175c67 !important; color: #fff;">
                <th colspan="2">BENEFICIO TOTAL</th>
                <th>$@convert(($cobrado_sum + $contratos[0]->inversion_us))</th>
              </tr>
            </tbody>
          </table>
        </div>
      @elseif ($contratos[0]->tipocontrato == 'Rendimiento compuesto')
        <div class="contenedor_tabla">
          <table class="tabla_reverso table table-sm">
            <thead>
              <tr style="background: #66cbdc !important; color: #fff;">
                <th>FECHA</th>
                <th>CAPITAL (USD)</th>
                <th>INTERÉS</th>
              </tr>
            </thead>
            <tbody>
              @php $acumulado = 0; @endphp
              @foreach ($amortizaciones as $amortizacion)
              <tr>
                <td>{{date("d/m/Y", strtotime($amortizacion->fecha))}}</td>
                @php
                  echo '<td style="background: #00b0f02f !important">$'.number_format($amortizacion->monto, 2).'</td>';
                  $acumulado += $amortizacion->redito;
                @endphp
                <td>$@convert($amortizacion->redito)</td>
              </tr>
              @endforeach
              <tr style="background: #00b0f0 !important; color: #fff;">
                <th colspan="2">ACUMULADO</th>
                <th>$@convert($acumulado)</th>
              </tr>
              <tr style="background: #0070c0 !important; color: #fff;">
                <th colspan="2">CAPITAL</th>
                <th>$@convert($amortizaciones[0]->monto)</th>
              </tr>
              <tr style="background: #175c67 !important; color: #fff;">
                <th colspan="2">BENEFICIO TOTAL</th>
                <th>$@convert($amortizaciones[0]->monto + $acumulado)</th>
              </tr>
            </tbody>
          </table>
        </div>
      @endif
    @endif
  
    <p class="mb-2 contrato_parrafo">
      Después de haberse leído íntegramente el presente contrato, ambas partes quedan conformes y conscientes de su
      contenido, valor y obligación contraída con el presente.
    </p>

    <p class="mb-2 contrato_parrafo">
      <span style="margin-left: 25px">En</span> caso de interpretación o incumplimiento del presente contrato, las partes se someten a la jurisdicción de los
      Tribunales del Estado de Durango, la validez del presente contrato comienza a partir de sus firmas y validaciones
      correspondiendo a la fecha del día <span style="text-decoration: underline">{{\Carbon\Carbon::parse(strtotime($contratos[0]->fecha))->formatLocalized('%d de %B de %Y')}}</span>. {{$contratos[0]->lugar_firma }}.
      @if (!empty($holograma2))
        <br>
        <span>
          Número de autorización: <span style="color: #0070c0 !important">{{$holograma2}}</span>
        </span>
      @endif
    </p>

    {{-- <div class="contenedor_firma">
      <div class="contenedor_firma__izquierda">
        <hr class="contenedor_firma__hr">
        <div class=" text-center">
          <p class="contrato_parrafo_firmas">
            <span>CLIENTE</span>
            <br>
            <span class="contrato_parrafo_firmas_nombre">{{ $contratos[0]->clientenombre }}</span>
          </p>
        </div>
      </div>
      <div class="contenedor_firma__derecha">
        <hr class="contenedor_firma__hr">
        <div class="text-center">
          <p class="contrato_parrafo_firmas">
            <span>UP TRADING EXPERTS</span>
            <br>
            @if ($contratos[0]->operador == "MARIA EUGENIA RINCON ACEVAL")
              <span>GERENTE GENERAL</span>
              <br>
            @endif
            <span class="contrato_parrafo_firmas_nombre">{{ $contratos[0]->operador }}</span>
          </p>
        </div>
      </div>
    </div> --}}
    <div class="contenedor_firma">
      <div class="contenedor_firma__izquierda" style="margin-top: -2rem">
        <div style="position: relative;">
          <img style="position: absolute; left: 80px;  top: -90px;" src="{{ public_path('img/firma.png') }}" alt="Rubrica" width="130" height="130">
        </div>
        <hr class="contenedor_firma__hr">
        <div class=" text-center">
          <p class="contrato_parrafo_firmas">
            <span>UP TRADING EXPERTS</span>
            <br>
            <span>REPRESENTANTE LEGAL</span>
            <br>
            <span class="contrato_parrafo_firmas_nombre">Hilario Hamilton Herrera Cossaín</span>
            {{-- @if ($contratos[0]->firma == "MARIA EUGENIA RINCON ACEVAL")
                <span>GERENTE GENERAL</span>
                <br>
                <span class="contrato_parrafo_firmas_nombre">{{$contratos[0]->firma}}</span>
            @else
                <span>REPRESENTANTE LEGAL</span>
            @endif --}}
          </p>
        </div>
      </div>
      <div class="contenedor_firma__derecha" style="margin-top: -2rem">
          <hr class="contenedor_firma__hr">
          <div class="text-center">
              <p class="contrato_parrafo_firmas">
                <span>CLIENTE</span>
                <br>
                <span class="contrato_parrafo_firmas_nombre">{{ $contratos[0]->clientenombre }}</span>
              </p>
          </div>
      </div>
      <div class="contenedor_firma__centro" style="margin-top: 4rem">
          <hr class="contenedor_firma__hr">
          <div class=" text-center">
              <p class="contrato_parrafo_firmas">
                  <span>UP TRADING EXPERTS</span>
                  <br>
                  <span>GERENTE GENERAL</span>
                  <br>
                  <span class="contrato_parrafo_firmas_nombre">MARIA EUGENIA RINCON ACEVAL</span>
                  {{-- @if ($contratos[0]->firma == "MARIA EUGENIA RINCON ACEVAL") --}}
                  {{-- @else --}}
                      {{-- <span>REPRESENTANTE LEGAL</span> --}}
                  {{-- @endif --}}
              </p>
          </div>
      </div>
    </div>
  </div>

    @if (!empty($holograma))
      @if (empty($holograma2))
        <p class="holo_inferior"><small>{{ $holograma }}</small></p>
      @endif
      <img class="imgUP_inferior_izq" src="{{ public_path('img/qr.png') }}" alt="Logo uptrading">
    @endif
    
    <img class="imgUP_superior" src="{{ public_path('img/logo_sup.png') }}" alt="Logo uptrading">
    <img class="imgUP_centro" src="{{ public_path('img/logo_centro.png') }}" alt="Logo uptrading">
    <img class="imgUP_inferior" src="{{ public_path('img/logo_latam.png') }}" alt="Logo uptrading">
@endsection