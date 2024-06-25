@extends('index')

@section('title', 'Gestión de citas')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css">
@endsection

@section('content')
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="info-fill" fill="#fff" viewBox="0 0 16 16">
            <path
                d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
        </symbol>
    </svg>

    <div class="pagetitle">
        <h1>Citas</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Vista general</a></li>
                <li class="breadcrumb-item active">Citas</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-primary d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                        <use xlink:href="#info-fill" />
                    </svg>
                    <div id="countCitas"></div>
                </div>

                <div class="card">
                    <div class="card-body mt-3">
                        <div class="row justify-content-end">
                            <div class="col-md-5 col-12 mb-2">
                                <form id="busquedaCitaForm" class="search-form-ticket d-flex align-items-center" method="POST" action="/admin/buscarCita">
                                    @csrf
                                    <input type="text" name="query_cita" placeholder="Buscar cita" id="busquedaCitaInput" title="Buscar cita">
                                    <input type="hidden" name="opc" id="opcInput">
                                    <button type="submit" title="Buscar"><i class="bi bi-search"></i></button>
                                    <button class="d-none" id="resetButton" type="reset" title="Resetear"><i class="bi bi-x-octagon"></i></button>
                                </form>
                            </div>
                        </div>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="abiertos-tab" data-bs-toggle="tab" data-bs-target="#abiertos-tab-pane" type="button" role="tab" aria-controls="abiertos-tab-pane" aria-selected="true" data-opc="pendiente">Citas pendientes</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="proceso-tab" data-bs-toggle="tab" data-bs-target="#proceso-tab-pane" type="button" role="tab" aria-controls="proceso-tab-pane" aria-selected="false" data-opc="proceso">Citas en proceso</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="cancelados-tab" data-bs-toggle="tab" data-bs-target="#cancelados-tab-pane" type="button" role="tab" aria-controls="cancelados-tab-pane" aria-selected="false" data-opc="cancelada">Citas canceladas</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="terminados-tab" data-bs-toggle="tab" data-bs-target="#terminados-tab-pane" type="button" role="tab" aria-controls="terminados-tab-pane" aria-selected="false" data-opc="atendida">Citas atendidas</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="contenidoCitas">
                            <div class="tab-pane fade show active" id="abiertos-tab-pane" role="tabpanel" aria-labelledby="abiertos-tab" tabindex="0">
                                @if(count($citas_pendientes) > 0)
                                    @foreach ($citas_pendientes as $cita_pendiente)
                                        <div class="col-lg-12 ps-3 pe-3">
                                            <div class="card border-0 mb-4 mt-4">
                                                <div class="flex-fill horizontal-card-bg-img2">
                                                    <div class="card-body ticket_body">
                                                        <div>
                                                            @if (Carbon\Carbon::now()->toDateTimeString() >= $cita_pendiente->dia.' '.$cita_pendiente->hora)
                                                                    @php
                                                                        $now = Carbon\Carbon::now();
                                                                        $limit = Carbon\Carbon::parse($cita_pendiente->dia.' '.$cita_pendiente->hora);
                                                                        $diff = $limit->diffForHumans();
                                                                    @endphp
                                                                    <span class="badge bg-danger mt-3"><i class="bi bi-info-circle-fill me-1"></i>La cita venció {{ $diff }}</span>
                                                            @endif
                                                            <div class="font-weight-bold mt-3"><b>{{$cita_pendiente->codigo_cliente}} - {{$cita_pendiente->apellido_p}} {{$cita_pendiente->apellido_m}} {{$cita_pendiente->nombre}}</b></div>
                                                            <div class="mb-3">
                                                                {{\Carbon\Carbon::parse($cita_pendiente->dia)->formatLocalized('%d de %B de %Y')}} a las {{\Carbon\Carbon::parse($cita_pendiente->hora)->format('H:i')}} hrs.
                                                            </div>
                                                        </div>
                                                        <div class="boton_auto_ticket">
                                                            <a class="mx-2 btn btn-sm principal-button detalles" data-id="{{ $cita_pendiente->id }}" data-codigo_cliente="{{ $cita_pendiente->codigo_cliente }}" data-nombre="{{ $cita_pendiente->nombre }}" data-apellido_p="{{ $cita_pendiente->apellido_p }}" data-apellido_m="{{ $cita_pendiente->apellido_m }}" data-telefono_alterno="{{ $cita_pendiente->telefono_alterno }}" data-correo_alterno="{{ $cita_pendiente->correo_alterno }}" data-dia="{{ $cita_pendiente->dia }}" data-hora="{{ $cita_pendiente->hora }}" data-contenido_llamada="{{$cita_pendiente->contenido_llamada}}" data-fecha_contenido_llamada="{{$cita_pendiente->fecha_contenido_llamada}}" data-acuerdo="{{$cita_pendiente->acuerdo}}" data-fecha_acuerdo="{{$cita_pendiente->fecha_acuerdo}}" data-firma_documento="{{$cita_pendiente->firma_documento}}" data-fecha_firma_documento="{{$cita_pendiente->fecha_firma_documento}}" data-otros_comentarios="{{$cita_pendiente->otros_comentarios}}" data-fecha_otros_comentarios="{{$cita_pendiente->fecha_otros_comentarios}}" data-estatus="{{$cita_pendiente->estatus}}" title="Detalles de la cita">Detalles de la cita</a>
                                                            <a class="mx-2 btn btn-sm btn-warning edit-cita" data-id="{{ $cita_pendiente->id }}" data-contenido_llamada="{{$cita_pendiente->contenido_llamada}}" data-fecha_contenido_llamada="{{$cita_pendiente->fecha_contenido_llamada}}" data-acuerdo="{{$cita_pendiente->acuerdo}}" data-fecha_acuerdo="{{$cita_pendiente->fecha_acuerdo}}" data-firma_documento="{{$cita_pendiente->firma_documento}}" data-fecha_firma_documento="{{$cita_pendiente->fecha_firma_documento}}" data-otros_comentarios="{{$cita_pendiente->otros_comentarios}}" data-fecha_otros_comentarios="{{$cita_pendiente->fecha_otros_comentarios}}" title="Bitacora">Bitacora</a>
                                                            <a class="mx-2 btn btn-sm btn-secondary horario" data-id="{{$cita_pendiente->id}}" data-dia="{{$cita_pendiente->dia}}" data-hora="{{$cita_pendiente->hora}}" title="Editar horario">Editar horario</a>
                                                            <a class="mx-2 btn btn-sm btn-success estatus" data-id="{{$cita_pendiente->id}}" data-estatus="{{$cita_pendiente->estatus}}" title="Editar estatus">Editar estatus</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="alert alert-info mt-3 mb-0" role="alert">
                                        <h4 class="alert-heading mb-0" style="font-size: 17px">No hay citas pendientes</h4>
                                    </div>
                                @endif
                            </div>
                            <div class="tab-pane fade" id="proceso-tab-pane" role="tabpanel" aria-labelledby="proceso-tab" tabindex="0">
                                @if(count($citas_proceso) > 0)
                                    @foreach ($citas_proceso as $cita_proceso)
                                        <div class="col-lg-12 ps-3 pe-3">
                                            <div class="card border-0 mb-4 mt-4">
                                                <div class="flex-fill horizontal-card-bg-img2">
                                                    <div class="card-body ticket_body">
                                                        <div>
                                                            @if (Carbon\Carbon::now()->toDateTimeString() >= $cita_proceso->dia.' '.$cita_proceso->hora)
                                                                    @php
                                                                        $now = Carbon\Carbon::now();
                                                                        $limit = Carbon\Carbon::parse($cita_proceso->dia.' '.$cita_proceso->hora);
                                                                        $diff = $limit->diffForHumans();
                                                                    @endphp
                                                                    <span class="badge bg-danger mt-3"><i class="bi bi-info-circle-fill me-1"></i>La cita venció {{ $diff }}</span>
                                                            @endif
                                                            <div class="font-weight-bold mt-3"><b>{{$cita_proceso->codigo_cliente}} - {{$cita_proceso->apellido_p}} {{$cita_proceso->apellido_m}} {{$cita_proceso->nombre}}</b></div>
                                                            <div class="mb-3">
                                                                {{\Carbon\Carbon::parse($cita_proceso->dia)->formatLocalized('%d de %B de %Y')}} a las {{\Carbon\Carbon::parse($cita_proceso->hora)->format('H:i')}} hrs.
                                                            </div>
                                                        </div>
                                                        <div class="boton_auto_ticket">
                                                            <a class="mx-2 btn btn-sm principal-button detalles" data-id="{{ $cita_proceso->id }}" data-codigo_cliente="{{ $cita_proceso->codigo_cliente }}" data-nombre="{{ $cita_proceso->nombre }}" data-apellido_p="{{ $cita_proceso->apellido_p }}" data-apellido_m="{{ $cita_proceso->apellido_m }}" data-telefono_alterno="{{ $cita_proceso->telefono_alterno }}" data-correo_alterno="{{ $cita_proceso->correo_alterno }}" data-dia="{{ $cita_proceso->dia }}" data-hora="{{ $cita_proceso->hora }}" data-contenido_llamada="{{$cita_proceso->contenido_llamada}}" data-fecha_contenido_llamada="{{$cita_proceso->fecha_contenido_llamada}}" data-acuerdo="{{$cita_proceso->acuerdo}}" data-fecha_acuerdo="{{$cita_proceso->fecha_acuerdo}}" data-firma_documento="{{$cita_proceso->firma_documento}}" data-fecha_firma_documento="{{$cita_proceso->fecha_firma_documento}}" data-otros_comentarios="{{$cita_proceso->otros_comentarios}}" data-fecha_otros_comentarios="{{$cita_proceso->fecha_otros_comentarios}}" data-estatus="{{$cita_proceso->estatus}}" title="Detalles de la cita">Detalles de la cita</a>
                                                            <a class="mx-2 btn btn-sm btn-warning edit-cita" data-id="{{ $cita_proceso->id }}" data-contenido_llamada="{{$cita_proceso->contenido_llamada}}" data-fecha_contenido_llamada="{{$cita_proceso->fecha_contenido_llamada}}" data-acuerdo="{{$cita_proceso->acuerdo}}" data-fecha_acuerdo="{{$cita_proceso->fecha_acuerdo}}" data-firma_documento="{{$cita_proceso->firma_documento}}" data-fecha_firma_documento="{{$cita_proceso->fecha_firma_documento}}" data-otros_comentarios="{{$cita_proceso->otros_comentarios}}" data-fecha_otros_comentarios="{{$cita_proceso->fecha_otros_comentarios}}" title="Bitacora">Bitacora</a>
                                                            <a class="mx-2 btn btn-sm btn-secondary horario" data-id="{{$cita_proceso->id}}" data-dia="{{$cita_proceso->dia}}" data-hora="{{$cita_proceso->hora}}" title="Editar horario">Editar horario</a>
                                                            <a class="mx-2 btn btn-sm btn-success estatus" data-id="{{$cita_proceso->id}}" data-estatus="{{$cita_proceso->estatus}}" title="Editar estatus">Editar estatus</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="alert alert-info mt-3 mb-0" role="alert">
                                        <h4 class="alert-heading mb-0" style="font-size: 17px">No hay citas en proceso</h4>
                                    </div>
                                @endif
                            </div>                        
                            <div class="tab-pane fade" id="cancelados-tab-pane" role="tabpanel" aria-labelledby="cancelados-tab" tabindex="0">
                                @if(count($citas_canceladas) > 0)
                                    @foreach ($citas_canceladas as $cita_cancelada)
                                        <div class="col-lg-12 ps-3 pe-3">
                                            <div class="card border-0 mb-4 mt-4">
                                                <div class="flex-fill horizontal-card-bg-img2">
                                                    <div class="card-body ticket_body">
                                                        <div>
                                                            <span class="badge bg-warning mt-3 text-dark"><i class="bi bi-info-circle-fill me-1"></i>Esta cita fue cancelada</span>
                                                            <div class="font-weight-bold mt-3"><b>{{$cita_cancelada->codigo_cliente}} - {{$cita_cancelada->apellido_p}} {{$cita_cancelada->apellido_m}} {{$cita_cancelada->nombre}}</b></div>
                                                            <div class="mb-3">
                                                                {{\Carbon\Carbon::parse($cita_cancelada->dia)->formatLocalized('%d de %B de %Y')}} a las {{\Carbon\Carbon::parse($cita_cancelada->hora)->format('H:i')}} hrs.
                                                            </div>
                                                        </div>
                                                        <div class="boton_auto_ticket">
                                                            <a class="mx-2 btn btn-sm principal-button detalles" data-id="{{ $cita_cancelada->id }}" data-codigo_cliente="{{ $cita_cancelada->codigo_cliente }}" data-nombre="{{ $cita_cancelada->nombre }}" data-apellido_p="{{ $cita_cancelada->apellido_p }}" data-apellido_m="{{ $cita_cancelada->apellido_m }}" data-telefono_alterno="{{ $cita_cancelada->telefono_alterno }}" data-correo_alterno="{{ $cita_cancelada->correo_alterno }}" data-dia="{{ $cita_cancelada->dia }}" data-hora="{{ $cita_cancelada->hora }}" data-contenido_llamada="{{$cita_cancelada->contenido_llamada}}" data-fecha_contenido_llamada="{{$cita_cancelada->fecha_contenido_llamada}}" data-acuerdo="{{$cita_cancelada->acuerdo}}" data-fecha_acuerdo="{{$cita_cancelada->fecha_acuerdo}}" data-firma_documento="{{$cita_cancelada->firma_documento}}" data-fecha_firma_documento="{{$cita_cancelada->fecha_firma_documento}}" data-otros_comentarios="{{$cita_cancelada->otros_comentarios}}" data-fecha_otros_comentarios="{{$cita_cancelada->fecha_otros_comentarios}}" data-estatus="{{$cita_cancelada->estatus}}" title="Detalles de la cita">Detalles de la cita</a>
                                                            <a class="mx-2 btn btn-sm btn-warning edit-cita" data-id="{{ $cita_cancelada->id }}" data-contenido_llamada="{{$cita_cancelada->contenido_llamada}}" data-fecha_contenido_llamada="{{$cita_cancelada->fecha_contenido_llamada}}" data-acuerdo="{{$cita_cancelada->acuerdo}}" data-fecha_acuerdo="{{$cita_cancelada->fecha_acuerdo}}" data-firma_documento="{{$cita_cancelada->firma_documento}}" data-fecha_firma_documento="{{$cita_cancelada->fecha_firma_documento}}" data-otros_comentarios="{{$cita_cancelada->otros_comentarios}}" data-fecha_otros_comentarios="{{$cita_cancelada->fecha_otros_comentarios}}" title="Bitacora">Bitacora</a>
                                                            <a class="mx-2 btn btn-sm btn-secondary horario" data-id="{{$cita_cancelada->id}}" data-dia="{{$cita_cancelada->dia}}" data-hora="{{$cita_cancelada->hora}}" title="Editar horario">Editar horario</a>
                                                            <a class="mx-2 btn btn-sm btn-success estatus" data-id="{{$cita_cancelada->id}}" data-estatus="{{$cita_cancelada->estatus}}" title="Editar estatus">Editar estatus</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="alert alert-info mt-3 mb-0" role="alert">
                                        <h4 class="alert-heading mb-0" style="font-size: 17px">No hay citas canceladas</h4>
                                    </div>
                                @endif
                            </div>
                            <div class="tab-pane fade" id="terminados-tab-pane" role="tabpanel" aria-labelledby="terminados-tab" tabindex="0">
                                @if(count($citas_atendidas) > 0)
                                    @foreach ($citas_atendidas as $cita_atendida)
                                        <div class="col-lg-12 ps-3 pe-3">
                                            <div class="card border-0 mb-4 mt-4">
                                                <div class="flex-fill horizontal-card-bg-img2">
                                                    <div class="card-body ticket_body">
                                                        <div>
                                                            <span class="badge bg-success mt-3"><i class="bi bi-info-circle-fill me-1"></i>La cita fue atendida con exito</span>
                                                            <div class="font-weight-bold mt-3"><b>{{$cita_atendida->codigo_cliente}} - {{$cita_atendida->apellido_p}} {{$cita_atendida->apellido_m}} {{$cita_atendida->nombre}}</b></div>
                                                            <div class="mb-3">
                                                                {{\Carbon\Carbon::parse($cita_atendida->dia)->formatLocalized('%d de %B de %Y')}} a las {{\Carbon\Carbon::parse($cita_atendida->hora)->format('H:i')}} hrs.
                                                            </div>
                                                        </div>
                                                        <div class="boton_auto_ticket">
                                                            <a class="mx-2 btn btn-sm principal-button detalles" data-id="{{ $cita_atendida->id }}" data-codigo_cliente="{{ $cita_atendida->codigo_cliente }}" data-nombre="{{ $cita_atendida->nombre }}" data-apellido_p="{{ $cita_atendida->apellido_p }}" data-apellido_m="{{ $cita_atendida->apellido_m }}" data-telefono_alterno="{{ $cita_atendida->telefono_alterno }}" data-correo_alterno="{{ $cita_atendida->correo_alterno }}" data-dia="{{ $cita_atendida->dia }}" data-hora="{{ $cita_atendida->hora }}" data-contenido_llamada="{{$cita_atendida->contenido_llamada}}" data-fecha_contenido_llamada="{{$cita_atendida->fecha_contenido_llamada}}" data-acuerdo="{{$cita_atendida->acuerdo}}" data-fecha_acuerdo="{{$cita_atendida->fecha_acuerdo}}" data-firma_documento="{{$cita_atendida->firma_documento}}" data-fecha_firma_documento="{{$cita_atendida->fecha_firma_documento}}" data-otros_comentarios="{{$cita_atendida->otros_comentarios}}" data-fecha_otros_comentarios="{{$cita_atendida->fecha_otros_comentarios}}" data-estatus="{{$cita_atendida->estatus}}" title="Detalles de la cita">Detalles de la cita</a>
                                                            <a class="mx-2 btn btn-sm btn-warning edit-cita" data-id="{{ $cita_atendida->id }}" data-contenido_llamada="{{$cita_atendida->contenido_llamada}}" data-fecha_contenido_llamada="{{$cita_atendida->fecha_contenido_llamada}}" data-acuerdo="{{$cita_atendida->acuerdo}}" data-fecha_acuerdo="{{$cita_atendida->fecha_acuerdo}}" data-firma_documento="{{$cita_atendida->firma_documento}}" data-fecha_firma_documento="{{$cita_atendida->fecha_firma_documento}}" data-otros_comentarios="{{$cita_atendida->otros_comentarios}}" data-fecha_otros_comentarios="{{$cita_atendida->fecha_otros_comentarios}}" title="Bitacora">Bitacora</a>
                                                            <a class="mx-2 btn btn-sm btn-secondary horario" data-id="{{$cita_atendida->id}}" data-dia="{{$cita_atendida->dia}}" data-hora="{{$cita_atendida->hora}}" title="Editar horario">Editar horario</a>
                                                            <a class="mx-2 btn btn-sm btn-success estatus" data-id="{{$cita_atendida->id}}" data-estatus="{{$cita_atendida->estatus}}" title="Editar estatus">Editar estatus</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="alert alert-info mt-3 mb-0" role="alert">
                                        <h4 class="alert-heading mb-0" style="font-size: 17px">No hay citas atendidas</h4>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="citaForm" method="post">
                        @csrf
                        <input type="hidden" name="id" id="idInput">
                        <input type="hidden" name="active" id="activeInput">
                        <div class="row">
                            <div class="col-md-6 col-12 campos-generales">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="codigoClienteInput">
                                    <label for="codigoClienteInput">Código de cliente</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 campos-generales">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="nombreInput">
                                    <label for="nombreInput">Nombre del cliente</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 campos-generales">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="apellidopInput">
                                    <label for="apellidopInput">Apellido paterno</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 campos-generales">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="apellidomInput">
                                    <label for="apellidomInput">Apellido materno</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 campos-generales">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="telefonoAlternoInput">
                                    <label for="telefonoAlternoInput">Teléfono alterno</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 campos-generales">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="correoAlternoInput">
                                    <label for="correoAlternoInput">Correo aleterno</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 campos-horario">
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" id="diaInput" name="dia">
                                    <label for="diaInput">Día de cita</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 campos-horario">
                                <div class="form-floating mb-3">
                                    <input type="time" class="form-control" id="horaInput" name="hora" step="60">
                                    <label for="horaInput">Hora de cita</label>
                                </div>
                            </div>

                            <div class="col-md-6 col-12 campos-bitacora">
                                <div class="form-floating mb-3">
                                    <textarea type="text" class="form-control" id="contenidoLlamadaInput" name="contenido_llamada" style="height: 150px; text-transform: none !important;" aria-describedby="actualizacionContenido"></textarea>
                                    <label for="contenidoLlamadaInput">Contenido de la llamada</label>
                                    <div id="actualizacionContenido" class="form-text"></div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 campos-bitacora">
                                <div class="form-floating mb-3">
                                    <textarea type="text" class="form-control" id="acuerdoInput" name="acuerdo" style="height: 150px; text-transform: none !important;" aria-describedby="actualizacionAcuerdo"></textarea>
                                    <label for="acuerdoInput">Acuerdo que se tuvo</label>
                                    <div id="actualizacionAcuerdo" class="form-text"></div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 campos-bitacora">
                                <div class="form-floating mb-3">
                                    <textarea type="text" class="form-control" id="firmaDocumentoInput" name="firma_documento" style="height: 150px; text-transform: none !important;" aria-describedby="actualizacionFirma"></textarea>
                                    <label for="firmaDocumentoInput">¿Se firmó algo?</label>
                                    <div id="actualizacionFirma" class="form-text"></div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 campos-bitacora">
                                <div class="form-floating mb-3">
                                    <textarea type="text" class="form-control" id="otrosComentariosInput" name="otros_comentarios" style="height: 150px; text-transform: none !important;" aria-describedby="actualizacionComentarios"></textarea>
                                    <label for="otrosComentariosInput">Otros comentarios</label>
                                    <div id="actualizacionComentarios" class="form-text"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="btnCancel" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn principal-button" id="btnSubmit"></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="estatusModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEstatusTitle">Editar el estatus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="citaEstatusForm" method="post">
                        @csrf
                        <input type="hidden" name="id_estatus" id="idEstatusInput">
                        <input type="hidden" name="active_estatus" id="activeEstatusInput">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <select name="estatus" class="form-control" id="estatusInput" required>
                                        <option disabled selected>Selecciona...</option>
                                        <option value="pendiente">Pendiente</option>
                                        <option value="proceso">En proceso</option>
                                        <option value="cancelada">Cancelada</option>
                                        <option value="atendida">Atendida</option>
                                    </select>
                                    <label for="estatusInput">Estatus</label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="btnEstatusCancel" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn principal-button" id="btnEstatusSubmit">Editar estatus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('preloader')
    <div id="loader" class="loader">
        <h1></h1>
        <span></span>
        <span></span>
        <span></span>
    </div>
@endsection

@section('footer')
    <footer id="footer" class="footer">
        <div class="copyright" id="copyright">
        </div>
        <div class="credits">
            Todos los derechos reservados
        </div>
    </footer>
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/locale/es.js"></script>
    <script src="{{ asset('js/citas.js') }}"></script>
@endsection