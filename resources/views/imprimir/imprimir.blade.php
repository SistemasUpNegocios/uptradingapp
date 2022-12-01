@extends('imprimir.imprimiranverso')

@section('title', 'VISTA PREVIA')

@section('content')
  <img class="imgUP_superior" src="{{ public_path('img/logo_sup.png') }}" alt="Logo uptrading">

  <img class="imgUP_centro" src="{{ public_path('img/logo_centro.png') }}" alt="">

  <img class="imgUP_inferior" src="{{ public_path('img/logo_latam.png') }}" alt="Logo uptrading">

  <div class="contenedor_imprimir_contrato">
    <p class="mb-3 contrato_parrafo" style="font-weight: bold; text-align: right">CONTRATO: {{ $contratos[0]->contrato}}</p>
    <p class="mb-3 contrato_parrafo" style="font-weight: bold; text-align: right">FOLIO: {{ $contratos[0]->folio}}</p>
    
    <p class="mb-3 contrato_parrafo text-center" style="font-weight: bold">INVERSIÓN A LARGO PLAZO</p>
    <p class="mb-3 text-center" style="font-weight: bold; text-transform: uppercase; margin-top: -1rem; color: #000;">{{ $contratos[0]->tipocontrato }}</p>

    <p class="mb-3 contrato_parrafo">
        Contrato de inversión a largo plazo con rendimiento mensual, celebrado por una parte por: <span
            style="text-transform: uppercase; font-weight: bold">{{ $contratos[0]->clientenombre }}</span> como "El Cliente" y Up Trading
        Experts como "El Operador" de inversión, representado por el Sr "{{ $contratos[0]->operador }}" que se
        identifica con el INE {{ $contratos[0]->operador_ine }}.
    </p>

    <p class="mb-3 text-center" style="font-weight: bold; text-transform: uppercase; color: #000;">DECLARACIONES</p>

    <p class="mb-3 contrato_parrafo">
        I. "El Cliente" declara que cuenta con domicilio en: <span style="text-decoration: underline">{{
            $contratos[0]->clientedomicilio }} C.P. {{ $contratos[0]->codigopostal }}</span>, se identifica con INE <span style="text-decoration: underline">{{ $contratos[0]->clienteine }}</span> con número
        de celular <span style="text-decoration: underline">{{ $contratos[0]->clientecelular }}</span> y email <span style="text-decoration: underline">{{ $contratos[0]->clientecorreo }}</span>.
    </p>

    <p class="mb-3 contrato_parrafo">
        II. "El Operador" el Sr. {{ $contratos[0]->operador }} declara que representa legalmente a la empresa Up Trading
        Experts, ubicada en Av. Universidad #234 Int. 308 con teléfono de oficina <span style="text-decoration: underline">8000878290</span> y con email
        <span style="text-decoration: underline">clientes@uptradingexperts.com</span>
    </p>

    <p class="mb-3 contrato_parrafo">
        III. Ambas partes declaran:
    </p>

      <ol type="A" class="center" style="color: #000">
          <li style="font-size: 10px">
              <p style="margin-bottom: -0.5rem">Ser personas físicas mayores de edad, se identifican ambas partes con
                  credencial oficial con fotografía.</p>
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
              <p style="margin-bottom: -0.5rem">Se estima un rendimiento del {{ str_replace("0.0","",
                  $contratos[0]->porcentaje) }}% mensual sobre el capital de inversión.
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
        $patrones[1] = '/{INVERSION_LETRA_US}/';
        $patrones[2] = '/{INVERSION}/';
        $patrones[3] = '/{INVERSION_LETRA}/';
        $patrones[4] = '/{PERIODO}/';
        $patrones[5] = '/{RENDIMIENTO}/';
        $patrones[6] = '/{CENTAVOS_US}/';
        $patrones[7] = '/{CENTAVOS}/';
        $patrones[8] = '/{BENEFICIARIOS}/';

        
        $sustituciones[0] = number_format($contratos[0]->inversion_us, 2);
        $sustituciones[1] = $contratos[0]->inversion_letra_us;
        $sustituciones[2] = number_format($contratos[0]->inversion, 2);
        $sustituciones[3] = $contratos[0]->inversion_letra;
        $sustituciones[4] = $contratos[0]->periodo;
        $sustituciones[5] = $contratos[0]->rendimiento;

        $moneyCentavos_us = strval($contratos[0]->inversion_us);
        $resultCentavos_us = explode(".", $moneyCentavos_us);

        if (next($resultCentavos_us)) {
          if (strlen($resultCentavos_us[1]) == 1) {
            $sustituciones[6] = ($resultCentavos_us[1], 0, 2) . "0";
          } else {
            $sustituciones[6] = ($resultCentavos_us[1], 0, 2);
          }
        } else {
          $sustituciones[6] = "00";
        }

        $moneyCentavos = strval($contratos[0]->inversion);
        $resultCentavos = explode(".", $moneyCentavos);

        if (next($resultCentavos)) {
          if (strlen($resultCentavos[1]) == 1) {
            $sustituciones[7] = ($resultCentavos[1], 0, 2) . "0";
          } else {
            $sustituciones[7] = ($resultCentavos[1], 0, 2);
          }
        } else {
          $sustituciones[7] = "00";
        }
        
        $sustituciones[8] = "<div class='contenedor_beneficiarios'>
                <div class='contenedor_beneficiarios_izquierda'>
                  <ol>          
                    <p class='contrato_parrafo_li text-center'>Nombre</p>";
                      foreach($beneficiarios as $beneficiario){
                        $sustituciones[8].="<li>$beneficiario->nombre</li>";
                      }
        $sustituciones[8].="</ol>
                </div>
                <div class='contenedor_beneficiarios_derecha'>
                  <ol>
                    <p class='contrato_parrafo_li text-center'>Porcentaje</p>";
                    foreach($beneficiarios as $beneficiario){
                      $sustituciones[8].="<li>$beneficiario->porcentaje%</li>";
                    }
        $sustituciones[8].="</ol>
                </div>
              </div>";

        echo preg_replace($patrones, $sustituciones, $clausula->redaccion);
        @endphp
      </p>
    @endforeach

    @if ($contratos[0]->tabla == true)      
      @if ($contratos[0]->tipocontrato == 'Rendimiento mensual')
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
              @foreach ($pagos_ps as $pago_ps)
              <tr>
                <td style="color: #85586F">{{date('d/m/Y', strtotime($pago_ps->fecha_pago_ps))}}</td>
                <td style="background: #e4ffdf">$@convert($pago_ps->inversion_us)</td>
                <td style="color: #85586F">$@convert($pago_ps->inversion_us * $pago_ps->rendimiento)</td>
              </tr>
              @endforeach
              <tr style="background: #4CACBC; color: #fff">
                <th colspan="2">COBRADO</th>
                <th>$@convert(($contratos[0]->inversion_us * $contratos[0]->rendimiento) * sizeof($contratos))</td>
              </tr>
              <tr style="background: #1363DF; color: #fff">
                <th colspan="2">CAPITAL</th>
                <th>$@convert($contratos[0]->inversion_us)</th>
              </tr>
              <tr style="background: #06283D; color: #fff">
                <th colspan="2">BENEFICIO TOTAL</th>
                <th>$@convert((($contratos[0]->inversion_us * $contratos[0]->rendimiento) * sizeof($contratos) +
                  $contratos[0]->inversion_us ))</th>
              </tr>
            </tbody>
          </table>
        </div>
      @elseif ($contratos[0]->tipocontrato == 'Rendimiento compuesto')
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
                $inversionUSD = $pagos_ps[0]->inversion_us;
              @endphp
              @foreach ($pagos_ps as $pago_ps)
              <tr>
                <td style="color: #85586F">{{date('d/m/Y', strtotime($pago_ps->fecha_pago_ps))}}</td>
                @php
                  echo '<td style="background: #e4ffdf">$'.number_format($inversionUSD, 2).'</td>';
                  $inversionUSD = $inversionUSD + $inversionUSD * $pago_ps->rendimiento;
                @endphp
                <td style="color: #85586F">$@convert($pago_ps->inversion_us * $pago_ps->rendimiento)</td>
              </tr>
              @endforeach
              <tr style="background: #4CACBC; color: #fff">
                <th colspan="2">COBRADO</th>
                <th>$@convert(($contratos[0]->inversion_us * $contratos[0]->rendimiento) * sizeof($contratos))</td>
              </tr>
              <tr style="background: #1363DF; color: #fff">
                <th colspan="2">CAPITAL</th>
                <th>$@convert($contratos[0]->inversion_us)</th>
              </tr>
              <tr style="background: #06283D; color: #fff">
                <th colspan="2">BENEFICIO TOTAL</th>
                <th>$@convert((($contratos[0]->inversion_us * $contratos[0]->rendimiento) * sizeof($contratos) +
                  $contratos[0]->inversion_us ))</th>
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
      En caso de interpretación o incumplimiento del presente contrato, las partes se someten a la jurisdicción de los
      Tribunales del Estado de Durango, la validez del presente contrato comienza a partir de sus firmas y
      correspondiendo a la fecha del día <span style="text-decoration: underline">{{date('d/m/Y', strtotime($contratos[0]->fecha))}}</span>. {{
      $contratos[0]->lugar_firma }}.
    </p>

    <div class="contenedor_firma">
      <div class="contenedor_firma__izquierda">
        <hr class="contenedor_firma__hr">
        <div class=" text-center">
          <p class="contrato_parrafo_firmas">
            <span>"El Cliente"</span>
            <br>
            <span class="contrato_parrafo_firmas_nombre">{{ $contratos[0]->clientenombre }}</span>
          </p>
        </div>
      </div>
      <div class="contenedor_firma__derecha">
        <hr class="contenedor_firma__hr">
        <div class="text-center">
          <p class="contrato_parrafo_firmas">
            <span>"El Operador"</span>
            <br>
            <span class="contrato_parrafo_firmas_nombre">{{ $contratos[0]->operador }}</span>
          </p>
        </div>
      </div>
      <div class="contenedor_firma__centro">
        <hr class="contenedor_firma__hr">
        <div class=" text-center">
          <p class="contrato_parrafo_firmas">
            <span>"El PS"</span>
            <br>
            <span class="contrato_parrafo_firmas_nombre">{{ $contratos[0]->psnombre }}</span>
          </p>
        </div>
      </div>
    </div>

  </div>

    <img class="imgUP_superior" src="{{ public_path('img/logo_sup.png') }}" alt="Logo uptrading">
    <img class="imgUP_centro" src="{{ public_path('img/logo_centro.png') }}" alt="">
    <img class="imgUP_inferior" src="{{ public_path('img/logo_latam.png') }}" alt="Logo uptrading">
@endsection