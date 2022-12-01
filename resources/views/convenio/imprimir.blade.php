@extends('convenio.indeximprimir')

@section('title', 'Convenio ' . $convenio[0]->folio)

@section('css')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<style>
    .page-break {
        page-break-after: always;
    }
</style>
@endsection

@section('content')
<img class="imgUP_superior" src="{{ public_path('img/logo_sup.png') }}" alt="Logo uptrading">

<img class="imgUP_centro" src="{{ public_path('img/logo_centro.png') }}" alt="">

<img class="imgUP_inferior" src="{{ public_path('img/logo_latam.png') }}" alt="Logo uptrading">

<div class="contenedor_imprimir_contrato" style="margin-top: -1.5rem">
    <p class="mb-3 contrato_parrafo" style="font-weight: bold; text-align: right">FOLIO: {{ $convenio[0]->folio}}</p>

    <p class="mb-0 text-center" style="font-weight: bold; text-transform: uppercase; margin-top: -1rem; color: #000;">
        Convenio</p>

    <p class="mb-0 contrato_parrafo">
        El presente convenio se suscribe entre "<span style="font-weight: bold">el Introducer Broker</span>", esto es:
        <span style="text-transform: uppercase; font-weight: bold">Up Trading Experts
            LLC</span> (en adelante "<span style="font-weight: bold">el IB</span>") y por otra parte <span
            style="text-transform: uppercase; font-weight: bold">{{ $convenio[0]->clientenombre
            }}</span> en lo sucesivo "<span style="font-weight: bold; text-transform: uppercase;">El cliente</span>".
    </p>

    <p class="mb-0 text-center" style="font-weight: bold; text-transform: uppercase; color: #000;">Cláusulas</p>

    <p class="mb-0 contrato_parrafo">
        Por lo tanto, las partes celebran el siguiente convenio:
    </p>


    <ol type="I">
        <li style="font-size: 10px; margin-bottom: -0.7rem">Objeto del Convenio</li>
    </ol>

    <ol type="I">
        <li style="font-size: 10px; margin-bottom: -0.7rem">
            <p class="mb-3 contrato_parrafo">"<span style="font-weight: bold; text-transform: uppercase;">El
                    cliente</span>" se compromete a respetar
                los plazos que acordarán para realizar análisis de sus operaciones como la revisión del rendimiento,
                mismo que será siempre cada 3 (tres) meses a partir de la fecha en que se realice el depósito del
                patrimonio, en la cuenta destinada para la operación contratada (Cuenta MAM), haciendo referencia al
                número de cuenta <span style="font-weight: bold; text-transform: uppercase;">{{
                    $convenio[0]->numerocuenta }}</span> en firme con el banco <span
                    style="text-transform: uppercase;">{{ $convenio[0]->banconombre }}</span>.</p>
        </li>
        <li style="font-size: 10px; margin-bottom: -0.7rem">
            <p class="mb-3 contrato_parrafo">"<span style="font-weight: bold; text-transform: uppercase;">El IB</span>"
                se compromete a realizar ante el cliente presente en oficinas, un análisis de sus operaciones, así como
                realizar una revisión de saldo de su cuenta MAM., para que en ese momento de la revisión de saldos se
                determine, en su caso, la autorización consensuada por ambas partes, del retiro total o parcial de
                rendimiento o el dejar en firme la totalidad de sus fondos en reinversión, y que continúe su saldo en
                operación.</p>
        </li>
        <li style="font-size: 10px; margin-bottom: -0.7rem">
            <p class="mb-3 contrato_parrafo">"<span style="font-weight: bold; text-transform: uppercase;">El
                    cliente</span>" se compromete a que durante el periodo contratado de 12 meses de operación de su
                cuenta MAM, en ningún momento realizará retiros de su patrimonio inicial con el que realizó la apertura
                de su cuenta.</p>
        </li>
        <li style="font-size: 10px; margin-bottom: -0.7rem">
            <p class="mb-3 contrato_parrafo">"<span style="font-weight: bold; text-transform: uppercase;">El
                    cliente</span>" cuando se llegue el tiempo de la revisión trimestral, acudirá personalmente y con
                previa cita acordada telefónicamente y que dicha cita haya sido confirmada a través del correo
                electrónico por parte de "<span style="font-weight: bold; text-transform: uppercase;">El IB</span>". En
                caso de no asistir a su cita deberá dar aviso ya que durante el tiempo que no termine este proceso la
                cuenta no estará generando rendimiento alguno. Y si "<span
                    style="font-weight: bold; text-transform: uppercase;">El cliente</span>" decide cancelar la cita y
                posponerla al siguiente trimestre para revisión o retiro, de igual forma deberá de dar aviso tanto
                telefónicamente como por correo electrónico.</p>
        </li>
        <li style="font-size: 10px; margin-bottom: -0.7rem">
            <p class="mb-3 contrato_parrafo">"<span style="font-weight: bold; text-transform: uppercase;">El
                    cliente</span>" si así lo decide y opta por realizar un retiro parcial o total de su rendimiento,
                este se realizará con una transferencia a la Tarjeta emitida por el Banco <span
                    style="text-transform: uppercase;">{{ $convenio[0]->banconombre }}</span>, o a otro medio de
                dispersión que el cliente decida y que sea factible de realizar.</p>
        </li>
        <li style="font-size: 10px; margin-bottom: -0.7rem">
            <p class="mb-3 contrato_parrafo">"<span style="font-weight: bold; text-transform: uppercase;">El
                    cliente</span>" en todo momento tiene el derecho de retirar sus rendimientos, en cualquiera de sus 3
                (tres) revisiones trimestrales, a las que tiene derecho durante la vigencia de su contrato de operación
                de cuenta MAM. Lo anterior quiere decir, que sin importar en cual revisión trimestral, "<span
                    style="font-weight: bold; text-transform: uppercase;">El cliente</span>" puede hacer uso de sus
                rendimientos siempre y cuando en ningún caso el retiro disminuya la cantidad con la que se celebró el
                contrato del cual se desprende este convenio.</p>
        </li>
        @php
        $monto = $convenio[0]->monto;
        $centavos = explode(".", $monto);

        if (array_key_exists(1, $centavos)) {
        $centavos_length = strlen($centavos[1]);
        if ($centavos_length == 2) {
        $centavos = $centavos[1];
        } else {
        $centavos = $centavos[1] . "0";
        }
        } else {
        $centavos = "00";
        }
        @endphp
        <li style="font-size: 10px; margin-bottom: -0.7rem">
            <p class="mb-3 contrato_parrafo">El presente convenio lo firman las partes aquí mencionadas por la cantidad
                de $@convert($convenio[0]->monto) <span style="text-transform: uppercase;">({{ $convenio[0]->monto_letra
                    }} {{ $centavos }}/100)</span> al día <span
                    style="text-decoration: underline">{{\Carbon\Carbon::parse(strtotime($convenio[0]->fecha_inicio))->formatLocalized('%d
                    de %B de %Y')}}</span>, quedando de acuerdo, después de haber leído cada uno de los puntos o
                cláusulas descritas, no quedando ningún punto por aclarar o entender. Siendo así que ambas partes se
                sujetan a lo dispuesto y conveniado.</p>
        </li>
    </ol>

    <div class="contenedor_firma">
        <div class="contenedor_firma__izquierda" style="margin-top: -1rem">
            <hr class="contenedor_firma__hr">
            <div class=" text-center">
                <p class="contrato_parrafo_firmas">
                    <span class="contrato_parrafo_firmas_nombre">Up Trading Experts</span>
                    <br>
                    <span>Representante Legal</span>
                </p>
            </div>
        </div>
        <div class="contenedor_firma__derecha" style="margin-top: -1rem">
            <hr class="contenedor_firma__hr">
            <div class="text-center">
                <p class="contrato_parrafo_firmas">
                    <span class="contrato_parrafo_firmas_nombre">{{ $convenio[0]->clientenombre }}</span>
                    <br>
                    <span>Cliente</span>
                </p>
            </div>
        </div>
        <div class="contenedor_firma__centro" style="margin-top: 4.2rem">
            <hr class="contenedor_firma__hr">
            <div class=" text-center">
                <p class="contrato_parrafo_firmas">
                    <span class="contrato_parrafo_firmas_nombre">{{ $convenio[0]->psnombre }}</span>
                    <br>
                    <span>PS</span>
                </p>
            </div>
        </div>
    </div>

</div>

<img class="imgUP_superior" src="{{ public_path('img/logo_sup.png') }}" alt="Logo uptrading">
<img class="imgUP_centro" src="{{ public_path('img/logo_centro.png') }}" alt="">
<img class="imgUP_inferior" src="{{ public_path('img/logo_latam.png') }}" alt="Logo uptrading">
@endsection