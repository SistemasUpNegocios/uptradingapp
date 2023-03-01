@if (sizeof($lista_oficinas) > 0)
    <div class="row mt-2">
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="d-flex">
                    <div class="horizontal-card-bg-img"></div>
                    <div class="card-body">
                        <h5 class="card-title">Foraneos</h5>
                        <p class="card-text">Presiona el botón para generar un resumen.</p>
                        <button class="btn btn-sm principal-button" id="foraneos">Crear resumen</button>
                    </div>
                </div>
            </div>
        </div>
        @foreach ($lista_oficinas as $oficina)
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="d-flex">
                    <div class="horizontal-card-bg-img"></div>
                    <div class="card-body">
                        <h5 class="card-title">Oficina en {{ $oficina->ciudad }}</h5>
                        <p class="card-text">Presiona el botón para generar un resumen.</p>
                        <button data-id="{{ $oficina->id }}" class="btn btn-sm principal-button" id="imprimirPagosClienteOficina">Crear resumen</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@else
    <div class="row" id="contVacio">
        <input type="hidden" value="vacio" id="vacioInput">
        <div class="col-12">
            <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                <symbol id="info-fill" fill="#fff" viewBox="0 0 16 16">
                    <path
                        d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                </symbol>
                <symbol id="exclamation-triangle-fill" fill="#fff" viewBox="0 0 16 16">
                    <path
                        d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                </symbol>
            </svg>
            <div class="alert alert-primary d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
                    aria-label="Info:">
                    <use xlink:href="#info-fill" />
                </svg>
                <div>
                    No se encontraron pagos para esta fecha.
                </div>
            </div>
        </div>
    </div>
@endif