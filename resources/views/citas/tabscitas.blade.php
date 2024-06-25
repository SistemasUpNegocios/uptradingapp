<div class="tab-pane fade {{$active == 'pendiente' ? 'show active' : ''}}" id="abiertos-tab-pane" role="tabpanel" aria-labelledby="abiertos-tab" tabindex="0">
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
                                <a class="mx-2 btn btn-sm btn-warning edit-cita" data-id="{{ $cita_pendiente->id }}" data-contenido_llamada="{{$cita_pendiente->contenido_llamada}}" data-fecha_contenido_llamada="{{$cita_pendiente->fecha_contenido_llamada}}" data-acuerdo="{{$cita_pendiente->acuerdo}}" data-fecha_acuerdo="{{$cita_pendiente->fecha_acuerdo}}" data-firma_documento="{{$cita_pendiente->firma_documento}}" data-fecha_firma_documento="{{$cita_pendiente->fecha_firma_documento}}" data-otros_comentarios="{{$cita_pendiente->otros_comentarios}}" data-fecha_otros_comentarios="{{$cita_pendiente->fecha_otros_comentarios}}" data-active="pendiente" title="Bitacora">Bitacora</a>
                                <a class="mx-2 btn btn-sm btn-secondary horario" data-id="{{$cita_pendiente->id}}" data-dia="{{$cita_pendiente->dia}}" data-hora="{{$cita_pendiente->hora}}" data-active="pendiente" title="Editar horario">Editar horario</a>
                                <a class="mx-2 btn btn-sm btn-success estatus" data-id="{{$cita_pendiente->id}}" data-estatus="{{$cita_pendiente->estatus}}" data-active="pendiente" title="Editar estatus">Editar estatus</a>
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
<div class="tab-pane fade {{$active == 'proceso' ? 'show active' : ''}}" id="proceso-tab-pane" role="tabpanel" aria-labelledby="proceso-tab" tabindex="0">
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
                                <a class="mx-2 btn btn-sm btn-warning edit-cita" data-id="{{ $cita_proceso->id }}" data-contenido_llamada="{{$cita_proceso->contenido_llamada}}" data-fecha_contenido_llamada="{{$cita_proceso->fecha_contenido_llamada}}" data-acuerdo="{{$cita_proceso->acuerdo}}" data-fecha_acuerdo="{{$cita_proceso->fecha_acuerdo}}" data-firma_documento="{{$cita_proceso->firma_documento}}" data-fecha_firma_documento="{{$cita_proceso->fecha_firma_documento}}" data-otros_comentarios="{{$cita_proceso->otros_comentarios}}" data-fecha_otros_comentarios="{{$cita_proceso->fecha_otros_comentarios}}" data-active="proceso" title="Bitacora">Bitacora</a>
                                <a class="mx-2 btn btn-sm btn-secondary horario" data-id="{{$cita_proceso->id}}" data-dia="{{$cita_proceso->dia}}" data-hora="{{$cita_proceso->hora}}" data-active="proceso" title="Editar horario">Editar horario</a>
                                <a class="mx-2 btn btn-sm btn-success estatus" data-id="{{$cita_proceso->id}}" data-estatus="{{$cita_proceso->estatus}}" data-active="proceso" title="Editar estatus">Editar estatus</a>
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
<div class="tab-pane fade {{$active == 'cancelada' ? 'show active' : ''}}" id="cancelados-tab-pane" role="tabpanel" aria-labelledby="cancelados-tab" tabindex="0">
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
                                <a class="mx-2 btn btn-sm btn-warning edit-cita" data-id="{{ $cita_cancelada->id }}" data-contenido_llamada="{{$cita_cancelada->contenido_llamada}}" data-fecha_contenido_llamada="{{$cita_cancelada->fecha_contenido_llamada}}" data-acuerdo="{{$cita_cancelada->acuerdo}}" data-fecha_acuerdo="{{$cita_cancelada->fecha_acuerdo}}" data-firma_documento="{{$cita_cancelada->firma_documento}}" data-fecha_firma_documento="{{$cita_cancelada->fecha_firma_documento}}" data-otros_comentarios="{{$cita_cancelada->otros_comentarios}}" data-fecha_otros_comentarios="{{$cita_cancelada->fecha_otros_comentarios}}" data-active="cancelada" title="Bitacora">Bitacora</a>
                                <a class="mx-2 btn btn-sm btn-secondary horario" data-id="{{$cita_cancelada->id}}" data-dia="{{$cita_cancelada->dia}}" data-hora="{{$cita_cancelada->hora}}" data-active="cancelada" title="Editar horario">Editar horario</a>
                                <a class="mx-2 btn btn-sm btn-success estatus" data-id="{{$cita_cancelada->id}}" data-estatus="{{$cita_cancelada->estatus}}" data-active="cancelada" title="Editar estatus">Editar estatus</a>
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
<div class="tab-pane fade {{$active == 'atendida' ? 'show active' : ''}}" id="terminados-tab-pane" role="tabpanel" aria-labelledby="terminados-tab" tabindex="0">
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
                                <a class="mx-2 btn btn-sm btn-warning edit-cita" data-id="{{ $cita_atendida->id }}" data-contenido_llamada="{{$cita_atendida->contenido_llamada}}" data-fecha_contenido_llamada="{{$cita_atendida->fecha_contenido_llamada}}" data-acuerdo="{{$cita_atendida->acuerdo}}" data-fecha_acuerdo="{{$cita_atendida->fecha_acuerdo}}" data-firma_documento="{{$cita_atendida->firma_documento}}" data-fecha_firma_documento="{{$cita_atendida->fecha_firma_documento}}" data-otros_comentarios="{{$cita_atendida->otros_comentarios}}" data-fecha_otros_comentarios="{{$cita_atendida->fecha_otros_comentarios}}" data-active="atendida" title="Bitacora">Bitacora</a>
                                <a class="mx-2 btn btn-sm btn-secondary horario" data-id="{{$cita_atendida->id}}" data-dia="{{$cita_atendida->dia}}" data-hora="{{$cita_atendida->hora}}" data-active="atendida" title="Editar horario">Editar horario</a>
                                <a class="mx-2 btn btn-sm btn-success estatus" data-id="{{$cita_atendida->id}}" data-estatus="{{$cita_atendida->estatus}}" data-active="atendida" title="Editar estatus">Editar estatus</a>
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