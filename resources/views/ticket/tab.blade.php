@if (auth()->user()->is_ps_gold)
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="generados-tab-pane" role="tabpanel" aria-labelledby="generados-tab" tabindex="0">
            @foreach ($tickets_generado as $ticket_generado)
                <div class="col-lg-12 ps-3 pe-3">
                    <div class="card border-0 mb-4 mt-4">
                        <div class="d-flex">
                            <div class="horizontal-card-bg-img"></div>
                            <div class="flex-fill">
                                <div class="card-body">
                                    @if (Carbon\Carbon::now()->toDateTimeString() >= $ticket_generado->fecha_limite)
                                        @php
                                            $now = Carbon\Carbon::now();
                                            $limit = Carbon\Carbon::parse($ticket_generado->fecha_limite);
                                            $diff = $limit->diffForHumans();
                                        @endphp
                                        @if ($ticket_generado->status == "Abierto" || $ticket_generado->status == "En proceso")
                                            <span class="badge bg-danger mt-3"><i class="bi bi-info-circle-fill me-1"></i>Este ticket venció {{ $diff }} y no fue atendido ni cancelado</span>
                                        @elseif($ticket_generado->status == "Cancelado")
                                            <span class="badge bg-warning text-dark mt-3"><i class="bi bi-info-circle-fill me-1"></i>Este ticket fue cancelado</span>
                                        @elseif($ticket_generado->status == "Terminado")
                                            <span class="badge bg-success mt-3"><i class="bi bi-info-circle-fill me-1"></i>Este ticket fue atendido con exito</span>
                                        @endif
                                    @else
                                        @if ($ticket_generado->status == "Abierto")
                                            <span class="badge bg-success mt-3"><i class="bi bi-info-circle-fill me-1"></i>Este ticket está abierto</span>
                                        @elseif($ticket_generado->status == "En proceso")
                                            <span class="badge bg-success mt-3"><i class="bi bi-info-circle-fill me-1"></i>Este ticket está en proceso</span>
                                        @elseif($ticket_generado->status == "Cancelado")
                                            <span class="badge bg-warning text-dark mt-3"><i class="bi bi-info-circle-fill me-1"></i>Este ticket fue cancelado</span>
                                        @elseif($ticket_generado->status == "Terminado")
                                            <span class="badge bg-success mt-3"><i class="bi bi-info-circle-fill me-1"></i>Este ticket fue atendido con exito</span>
                                        @endif
                                    @endif
                                    <div class="font-weight-bold mt-3"><b>{{ $ticket_generado->asunto }}</b>
                                    </div>
                                    <div class="mb-3">
                                        @if (strlen($ticket_generado->descripcion) >= 80)
                                            {{ substr($ticket_generado->descripcion, 0, 80) }}...
                                        @else
                                            {{ substr($ticket_generado->descripcion, 0, 30) }}
                                        @endif
                                    </div>
                                </div>
                            </div>
        
                            <div class="px-2 d-flex justify-content-center align-items-center">
                                <a class="btn btn-sm btn-success edit" data-id="{{$ticket_generado->id}}" data-generado="{{$ticket_generado->usuarionombre}}" data-asignado="{{$ticket_generado->asignado_a}}" data-fechagenerado="{{$ticket_generado->fecha_generado}}" data-fechalimite="{{$ticket_generado->fecha_limite}}" data-departamento="{{$ticket_generado->departamento}}" data-asunto="{{$ticket_generado->asunto}}" data-descripcion="{{$ticket_generado->descripcion}}" data-status="{{$ticket_generado->status}}" title="Editar ticket">Editar ticket</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@else
    <div class="tab-pane fade" id="abiertos-tab-pane" role="tabpanel" aria-labelledby="abiertos-tab" tabindex="0">
        @foreach ($tickets_user_abiertos as $ticket_abierto)
            <div class="col-lg-12 ps-3 pe-3">
                <div class="card border-0 mb-4 mt-4">
                    <div class="d-flex">
                        <div class="horizontal-card-bg-img"></div>
                        <div class="flex-fill">
                            <div class="card-body">
                                @if (Carbon\Carbon::now()->toDateTimeString() >= $ticket_abierto->fecha_limite)
                                    @php
                                        $now = Carbon\Carbon::now();
                                        $limit = Carbon\Carbon::parse($ticket_abierto->fecha_limite);
                                        $diff = $limit->diffForHumans();
                                    @endphp
                                    <span class="badge bg-danger mt-3"><i class="bi bi-info-circle-fill me-1"></i>Este ticket venció {{ $diff }}</span>
                                @endif
                                <div class="font-weight-bold mt-3"><b>{{ $ticket_abierto->asunto }}</b>
                                </div>
                                <div class="mb-3">
                                    @if (strlen($ticket_abierto->descripcion) >= 80)
                                        {{ substr($ticket_abierto->descripcion, 0, 80) }}...
                                    @else
                                        {{ substr($ticket_abierto->descripcion, 0, 30) }}
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="px-2 d-flex justify-content-center align-items-center">
                            <a class="mx-2 btn btn-sm principal-button detalles" data-id="{{$ticket_abierto->ticketid}}" data-generado="{{$ticket_abierto->usuarionombre}}" data-asignado="{{$ticket_abierto->asignado_a}}" data-fechagenerado="{{$ticket_abierto->fecha_generado}}" data-fechalimite="{{$ticket_abierto->fecha_limite}}" data-departamento="{{$ticket_abierto->departamento}}" data-asunto="{{$ticket_abierto->asunto}}" data-descripcion="{{$ticket_abierto->descripcion}}" data-status="{{$ticket_abierto->status}}" title="Ver detalles del ticket">Ver detalles del ticket</a>
                            <a class="mx-2 btn btn-sm btn-success status" data-id="{{$ticket_abierto->ticketid}}" data-status="{{$ticket_abierto->status}}" title="Ver detalles del ticket">Editar estatus</a>
                            <a class="mx-2 btn btn-sm btn-secondary traspasar" data-id="{{$ticket_abierto->ticketid}}" title="Transpasar ticket">Traspasar ticket</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="tab-pane fade" id="proceso-tab-pane" role="tabpanel" aria-labelledby="proceso-tab" tabindex="0">
        @foreach ($tickets_user_procesos as $ticket_proceso)
            <div class="col-lg-12 ps-3 pe-3">
                <div class="card border-0 mb-4 mt-4">
                    <div class="d-flex">
                        <div class="horizontal-card-bg-img"></div>
                        <div class="flex-fill">
                            <div class="card-body">
                                @if (Carbon\Carbon::now()->toDateTimeString() >= $ticket_proceso->fecha_limite)
                                    @php
                                        $now = Carbon\Carbon::now();
                                        $limit = Carbon\Carbon::parse($ticket_proceso->fecha_limite);
                                        $diff = $limit->diffForHumans();
                                    @endphp
                                    <span class="badge bg-danger mt-3"><i class="bi bi-info-circle-fill me-1"></i>Este ticket venció {{ $diff }}</span>
                                @endif
                                <div class="font-weight-bold mt-3"><b>{{ $ticket_proceso->asunto }}</b>
                                </div>
                                <div class="mb-3">
                                    @if (strlen($ticket_proceso->descripcion) >= 80)
                                        {{ substr($ticket_proceso->descripcion, 0, 80) }}...
                                    @else
                                        {{ substr($ticket_proceso->descripcion, 0, 30) }}
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="px-2 d-flex justify-content-center align-items-center">
                            <a class="mx-2 btn btn-sm principal-button detalles" data-id="{{$ticket_proceso->ticketid}}" data-generado="{{$ticket_proceso->usuarionombre}}" data-asignado="{{$ticket_proceso->asignado_a}}" data-fechagenerado="{{$ticket_proceso->fecha_generado}}" data-fechalimite="{{$ticket_proceso->fecha_limite}}" data-departamento="{{$ticket_proceso->departamento}}" data-asunto="{{$ticket_proceso->asunto}}" data-descripcion="{{$ticket_proceso->descripcion}}" data-status="{{$ticket_proceso->status}}" title="Ver detalles del ticket">Ver detalles del ticket</a>
                            <a class="mx-2 btn btn-sm btn-success status" data-id="{{$ticket_proceso->ticketid}}" data-status="{{$ticket_proceso->status}}" title="Ver detalles del ticket">Editar estatus</a>
                            <a class="mx-2 btn btn-sm btn-secondary traspasar" data-id="{{$ticket_proceso->ticketid}}" title="Transpasar ticket">Traspasar ticket</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>                        
    <div class="tab-pane fade" id="cancelados-tab-pane" role="tabpanel" aria-labelledby="cancelados-tab" tabindex="0">
        @foreach ($tickets_user_cancelados as $ticket_cancelado)
            <div class="col-lg-12 ps-3 pe-3">
                <div class="card border-0 mb-4 mt-4">
                    <div class="d-flex">
                        <div class="horizontal-card-bg-img"></div>
                        <div class="flex-fill">
                            <div class="card-body">                                                    
                                <span class="badge bg-warning text-dark mt-3"><i class="bi bi-info-circle-fill me-1"></i>Este ticket fue cancelado</span>
                                <div class="font-weight-bold mt-3"><b>{{ $ticket_cancelado->asunto }}</b>
                                </div>
                                <div class="mb-3">
                                    @if (strlen($ticket_cancelado->descripcion) >= 80)
                                        {{ substr($ticket_cancelado->descripcion, 0, 80) }}...
                                    @else
                                        {{ substr($ticket_cancelado->descripcion, 0, 30) }}
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="px-2 d-flex justify-content-center align-items-center">
                            <a class="mx-2 btn btn-sm principal-button detalles" data-id="{{$ticket_cancelado->ticketid}}" data-generado="{{$ticket_cancelado->usuarionombre}}" data-asignado="{{$ticket_cancelado->asignado_a}}" data-fechagenerado="{{$ticket_cancelado->fecha_generado}}" data-fechalimite="{{$ticket_cancelado->fecha_limite}}" data-departamento="{{$ticket_cancelado->departamento}}" data-asunto="{{$ticket_cancelado->asunto}}" data-descripcion="{{$ticket_cancelado->descripcion}}" data-status="{{$ticket_cancelado->status}}" title="Ver detalles del ticket">Ver detalles del ticket</a>
                            <a class="mx-2 btn btn-sm btn-success status" data-id="{{$ticket_cancelado->ticketid}}" data-status="{{$ticket_cancelado->status}}" title="Ver detalles del ticket">Editar estatus</a>
                            <a class="mx-2 btn btn-sm btn-secondary traspasar" data-id="{{$ticket_cancelado->ticketid}}" title="Transpasar ticket">Traspasar ticket</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="tab-pane fade" id="terminados-tab-pane" role="tabpanel" aria-labelledby="terminados-tab" tabindex="0">
        @foreach ($tickets_user_terminados as $ticket_terminado)
            <div class="col-lg-12 ps-3 pe-3">
                <div class="card border-0 mb-4 mt-4">
                    <div class="d-flex">
                        <div class="horizontal-card-bg-img"></div>
                        <div class="flex-fill">
                            <div class="card-body">
                                <span class="badge bg-success mt-3"><i class="bi bi-info-circle-fill me-1"></i>Este ticket fue atendido con exito</span>
                                <div class="font-weight-bold mt-3"><b>{{ $ticket_terminado->asunto }}</b>
                                </div>
                                <div class="mb-3">
                                    @if (strlen($ticket_terminado->descripcion) >= 80)
                                        {{ substr($ticket_terminado->descripcion, 0, 80) }}...
                                    @else
                                        {{ substr($ticket_terminado->descripcion, 0, 30) }}
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="px-2 d-flex justify-content-center align-items-center">
                            <a class="btn btn-sm principal-button detalles" data-id="{{$ticket_terminado->ticketid}}" data-generado="{{$ticket_terminado->usuarionombre}}" data-asignado="{{$ticket_terminado->asignado_a}}" data-fechagenerado="{{$ticket_terminado->fecha_generado}}" data-fechalimite="{{$ticket_terminado->fecha_limite}}" data-departamento="{{$ticket_terminado->departamento}}" data-asunto="{{$ticket_terminado->asunto}}" data-descripcion="{{$ticket_terminado->descripcion}}" data-status="{{$ticket_terminado->status}}" title="Ver detalles del ticket">Ver detalles del ticket</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="tab-pane fade" id="generados-tab-pane" role="tabpanel" aria-labelledby="generados-tab" tabindex="0">
        @foreach ($tickets_generado as $ticket_generado)
            <div class="col-lg-12 ps-3 pe-3">
                <div class="card border-0 mb-4 mt-4">
                    <div class="d-flex">
                        <div class="horizontal-card-bg-img"></div>
                        <div class="flex-fill">
                            <div class="card-body">
                                @if (Carbon\Carbon::now()->toDateTimeString() >= $ticket_generado->fecha_limite)
                                    @php
                                        $now = Carbon\Carbon::now();
                                        $limit = Carbon\Carbon::parse($ticket_generado->fecha_limite);
                                        $diff = $limit->diffForHumans();
                                    @endphp
                                    @if ($ticket_generado->status == "Abierto" || $ticket_generado->status == "En proceso")
                                        <span class="badge bg-danger mt-3"><i class="bi bi-info-circle-fill me-1"></i>Este ticket venció {{ $diff }} y no fue atendido ni cancelado</span>
                                    @elseif($ticket_generado->status == "Cancelado")
                                        <span class="badge bg-warning text-dark mt-3"><i class="bi bi-info-circle-fill me-1"></i>Este ticket fue cancelado</span>
                                    @elseif($ticket_generado->status == "Terminado")
                                        <span class="badge bg-success mt-3"><i class="bi bi-info-circle-fill me-1"></i>Este ticket fue atendido con exito</span>
                                    @endif
                                @else
                                    @if ($ticket_generado->status == "Abierto")
                                        <span class="badge bg-success mt-3"><i class="bi bi-info-circle-fill me-1"></i>Este ticket está abierto</span>
                                    @elseif($ticket_generado->status == "En proceso")
                                        <span class="badge bg-success mt-3"><i class="bi bi-info-circle-fill me-1"></i>Este ticket está en proceso</span>
                                    @elseif($ticket_generado->status == "Cancelado")
                                        <span class="badge bg-warning text-dark mt-3"><i class="bi bi-info-circle-fill me-1"></i>Este ticket fue cancelado</span>
                                    @elseif($ticket_generado->status == "Terminado")
                                        <span class="badge bg-success mt-3"><i class="bi bi-info-circle-fill me-1"></i>Este ticket fue atendido con exito</span>
                                    @endif
                                @endif
                                <div class="font-weight-bold mt-3"><b>{{ $ticket_generado->asunto }}</b>
                                </div>
                                <div class="mb-3">
                                    @if (strlen($ticket_generado->descripcion) >= 80)
                                        {{ substr($ticket_generado->descripcion, 0, 80) }}...
                                    @else
                                        {{ substr($ticket_generado->descripcion, 0, 30) }}
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="px-2 d-flex justify-content-center align-items-center">
                            <a class="btn btn-sm btn-success edit" data-id="{{$ticket_generado->id}}" data-generado="{{$ticket_generado->usuarionombre}}" data-asignado="{{$ticket_generado->asignado_a}}" data-fechagenerado="{{$ticket_generado->fecha_generado}}" data-fechalimite="{{$ticket_generado->fecha_limite}}" data-departamento="{{$ticket_generado->departamento}}" data-asunto="{{$ticket_generado->asunto}}" data-descripcion="{{$ticket_generado->descripcion}}" data-status="{{$ticket_generado->status}}" title="Editar ticket">Editar ticket</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

{{-- Input escondido para cambiar el numero de tickets abiertos --}}
<input type="hidden" id="countInput" value="{{$count}}">