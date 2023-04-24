@extends('convenio.indeximprimir')

@section('title', 'Convenio ' . $convenio[0]->folio)

@section('css')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <style>
        .page-break {
            page-break-after: always;
        }
        .contrato_parrafo {
            line-height: 10px !important;
        }
    </style>
@endsection

@section('content')
    <img class="imgUP_superior" src="{{ public_path('img/logo_sup.png') }}" alt="Logo uptrading">

    <img class="imgUP_centro" src="{{ public_path('img/logo_centro.png') }}" alt="">

    <img class="imgUP_inferior" src="{{ public_path('img/logo_latam.png') }}" alt="Logo uptrading">

    <div class="contenedor_imprimir_contrato">
        <p class="mb-3 contrato_parrafo" style="font-weight: bold; text-align: center; line-height: 10px !important;">FOLIO: {{ $convenio[0]->folio }}</p>

        <p class="mb-0 text-center" style="font-weight: bold; text-transform: uppercase; margin-top: -1rem; color: #000;">
            Convenio</p>

            <div class="parrafos_incremento">

        
        <p class="mb-0 mt-2 contrato_parrafo" style="line-height: 20px !important;">
            El presente incremento de convenio se suscribe entre "<span style="font-weight: bold">el Introducer Broker</span>", esto es: <span style="text-transform: uppercase; font-weight: bold">UP TRADING EXPERTS </span> (en adelante "<span style="font-weight: bold">el IB</span>") y por otra parte <span
                style="text-transform: uppercase; font-weight: bold">{{ $convenio[0]->clientenombre }}</span> en lo sucesivo
            "<span style="font-weight: bold; text-transform: uppercase;">EL CLIENTE</span>".
        </p>

        <p class="mb-0 contrato_parrafo" style="line-height: 20px !important;">
            Por lo tanto, las partes acuerdan lo siguiente:
        </p>

        <p class="mb-0 contrato_parrafo" style="line-height: 20px !important;">
            El incremento se hará al convenio <b>{{$convenio[0]->folioinicio}}</b> firmado con fecha de {{ \Carbon\Carbon::parse(strtotime($convenio[0]->fecha_inicio))->formatLocalized('%d de %B de %Y') }}, con un capital de inicio de <u>${{number_format($convenio[0]->monto, 2)}}</u>, el cual se aumentrá en <u>${{number_format($convenio[0]->cantidad_incremento, 2)}}</u> con fecha de {{ \Carbon\Carbon::parse(strtotime($convenio[0]->fecha_inicio_incremento))->formatLocalized('%d de %B de %Y') }}.
        </p>
        <p class="mb-0 contrato_parrafo" style="line-height: 20px !important;">
            Se respetará la vigencia del convenio pactada en un principio. Por lo que este aumento se ajustará a la fecha inicial, el cual tiene vigencia de 12 meses.
        </p>
    </div>
        <div class="contenedor_firma">
            <div class="contenedor_firma__izquierda" style="margin-top:-1.5rem">
                <hr class="contenedor_firma__hr">
                <div class=" text-center">
                    <p class="contrato_parrafo_firmas">
                        <span class="contrato_parrafo_firmas_nombre">{{ $convenio[0]->psnombre }}</span>
                        <br>
                        <span>PS</span>
                    </p>
                </div>
            </div>
            <div class="contenedor_firma__derecha"  style="margin-top:-1.5rem">
                <hr class="contenedor_firma__hr">
                <div class="text-center">
                    <p class="contrato_parrafo_firmas">
                        <span class="contrato_parrafo_firmas_nombre">{{ $convenio[0]->clientenombre }}</span>
                        <br>
                        <span>CLIENTE</span>
                    </p>
                </div>
            </div>
            <div class="contenedor_firma__centro"  style="margin-top:3.5rem">
                <hr class="contenedor_firma__hr">
                <div class=" text-center">
                    <p class="contrato_parrafo_firmas">
                        <span>UP TRADING EXPERTS</span>
                        <br>
                        @if ($convenio[0]->firma == "MARIA EUGENIA RINCON ACEVAL")
                            <span>GERENTE GENERAL</span>
                            <br>
                            <span class="contrato_parrafo_firmas_nombre">{{$convenio[0]->firma}}</span>
                        @else
                            <span>REPRESENTANTE LEGAL</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

    </div>

    <img class="imgUP_superior" src="{{ public_path('img/logo_sup.png') }}" alt="Logo uptrading">
    <img class="imgUP_centro" src="{{ public_path('img/logo_centro.png') }}" alt="">
    <img class="imgUP_inferior" src="{{ public_path('img/logo_latam.png') }}" alt="Logo uptrading">
@endsection
