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
@isset($status)
<a class="btn principal-button mb-3 new" id="btnVolverOficinas"> <i class="bi-chevron-left me-1"></i>Volver a ver
    oficinas</a>

<div class="row">
    <div class="col-12">
        <div class="alert alert-warning d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:">
                <use xlink:href="#exclamation-triangle-fill" />
            </svg>
            <div> 
                Lo sentimos, no hay ningún PS registrado en esta oficina. <a href="{{ url('/admin/ps') }}" class="enlacePS" title="Ir a gestión de PS">Registra uno ahora</a>.
            </div>
        </div>
    </div>
</div>
@else

    <a class="btn principal-button mb-3 new" id="btnVolverOficinas"> <i class="bi-chevron-left me-1"></i>Volver a ver oficinas</a>
    <div class="row">
        <div class="col-12">
            <div class="alert alert-primary d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
                    aria-label="Info:">
                    <use xlink:href="#info-fill" />
                </svg>
                <div>
                    Si quieres generar un resumen por oficina selecciona primero la fecha.
                </div>
            </div>
        </div>
    </div>
    <div class="row align-items-center justify-content-between mb-3">
        <div class="col-md-6 col-12">
            <div class="form-floating mb-3">
                <input type="month" class="form-control" id="fechaInputOficina" name="fecha">
                <label for="fechaInput">Fecha de pago</label>
            </div>
        </div>
        <div class="col-md-6 col-12  d-flex justify-content-end">
            <a class="btn principal-button mb-3" id="imprimirResumenOficina"> <i class="bi bi-printer-fill me-1"></i>Imprimir resumen de oficina</a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="alert alert-primary d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                    <use xlink:href="#info-fill" />
                </svg>
                <div>
                    Selecciona un PS para crear un resumen de PS:
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @foreach ($lista_ps as $ps)
        <div class="col-sm-6">
            <div class="card border-0 mb-4 pe-3">
                <div class="d-flex justify-content-between">
                    <div class="horizontal-card-bg-img"></div>
                    <div class="ms-2 justify-content-center align-items-center">
                        <div class="font-weight-bold mt-3"><b>{{ $ps->nombre . ' ' . $ps->apellido_p . ' ' .
                                $ps->apellido_m}}</b></div>
                        <div class="mb-3">PS {{ $ps->tipo_ps }}</div>
                    </div>
                    <div class="horizontal-card-btn-container d-flex align-items-center justify-content-end">
                        <a class="btn btn-sm principal-button me-2 showLista" data-id="{{ $ps->id }}"
                            title="Crear resumen de {{ $ps->nombre }}">Crear resumen</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endisset