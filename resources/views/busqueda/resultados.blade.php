<span id="query" class="d-none" data-query="{{ $query }}"></span>

<h4 class="fw-bolder mb-2">Resultado principal</h4>

@foreach ($clientes->take(1) as $cliente)
<div class="text-center">
<h3 class="fw-bolder">{{ $cliente->apellido_p }} {{ $cliente->apellido_m }} {{ $cliente->nombre }}</h3>
<h4 class="fw-bolder mb-4" id="codigo_principal">{{ $cliente->codigoCliente }} <i class="bi bi-clipboard ms-2 copiar" data-id="codigo_principal" style="cursor: pointer;" title="Copiar al portapapeles"></i></h4>
    </div>
@endforeach


@if ($clientes->count() > 1)
<p>Se encontraron otros <span class="fw-bolder">{{ $clientes->skip(1)->count() }}</span> que coinciden con la búsqueda,
    haz clic abajo para desplegar:</p>

<div class="accordion" id="accordionExample">
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingTwo">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Desplegar otros&nbsp;<span class="fw-bolder"> {{ $clientes->skip(1)->count() }} </span>&nbsp;resultados
            </button>
        </h2>
        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
            data-bs-parent="#accordionExample">
            <div class="accordion-body">
                @php
                $i = 1;
                $nombre_cliente = "";
                @endphp
                @foreach ($clientes->skip(1) as $cliente)
                @php
                $i++;
                $nombre_cliente = $cliente->nombre . ' ' . $cliente->apellido_p . ' ' . $cliente->apellido_m;
                $nombre_cliente = preg_replace('/(' . $query . ')/i', "<span class='fw-bolder'>$1</span>",
                $nombre_cliente);
                @endphp


                <p>{!! $nombre_cliente !!} - <span id="codigo{{ $i }}" class="fw-bolder">{{ $cliente->codigoCliente }}</span><i class="bi bi-clipboard ms-2 copiar" data-id="codigo{{ $i }}" style="cursor: pointer;" title="Copiar al portapapeles"></i></p>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif