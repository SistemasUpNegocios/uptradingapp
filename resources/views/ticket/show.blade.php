@php
    if(sizeof($tickets_generado) > 0){
        $clase_abiertos = '';
        $nav_abiertos = '';

        $clase_procesos = '';
        $nav_procesos = '';

        $clase_cancelados = '';
        $nav_cancelados = '';

        $clase_terminados = '';
        $nav_terminados = '';

        $clase_generados = 'show active';
        $nav_generados = 'active';

        $clase_archivados = '';
        $nav_archivados = '';
    }elseif(sizeof($tickets_user_procesos) > 0){
        $clase_abiertos = '';
        $nav_abiertos = '';

        $clase_procesos = 'show active';
        $nav_procesos = 'active';

        $clase_cancelados = '';
        $nav_cancelados = '';

        $clase_terminados = '';
        $nav_terminados = '';

        $clase_generados = '';
        $nav_generados = '';

        $clase_archivados = '';
        $nav_archivados = '';
    }elseif(sizeof($tickets_user_abiertos) > 0){
        $clase_abiertos = 'show active';
        $nav_abiertos = 'active';

        $clase_procesos = '';
        $nav_procesos = '';

        $clase_cancelados = '';
        $nav_cancelados = '';

        $clase_terminados = '';
        $nav_terminados = '';

        $clase_generados = '';
        $nav_generados = '';

        $clase_archivados = '';
        $nav_archivados = '';
    }elseif(sizeof($tickets_user_cancelados) > 0){
        $clase_abiertos = '';
        $nav_abiertos = '';

        $clase_procesos = '';
        $nav_procesos = '';

        $clase_cancelados = 'show active';
        $nav_cancelados = 'active';

        $clase_terminados = '';
        $nav_terminados = '';

        $clase_generados = '';
        $nav_generados = '';

        $clase_archivados = '';
        $nav_archivados = '';
    }elseif(sizeof($tickets_user_terminados) > 0){
        $clase_abiertos = '';
        $nav_abiertos = '';

        $clase_procesos = '';
        $nav_procesos = '';

        $clase_cancelados = '';
        $nav_cancelados = '';

        $clase_terminados = 'show active';
        $nav_terminados = 'active';

        $clase_generados = '';
        $nav_generados = '';

        $clase_archivados = '';
        $nav_archivados = '';
    }elseif(sizeof($tickets_archivados) > 0){
        $clase_abiertos = '';
        $nav_abiertos = '';

        $clase_procesos = '';
        $nav_procesos = '';

        $clase_cancelados = '';
        $nav_cancelados = '';

        $clase_terminados = '';
        $nav_terminados = '';

        $clase_generados = '';
        $nav_generados = '';

        $clase_archivados = 'show active';
        $nav_archivados = 'active';
    }else{
        $clase_abiertos = 'show active';
        $nav_abiertos = 'active';

        $clase_procesos = '';
        $nav_procesos = '';

        $clase_cancelados = '';
        $nav_cancelados = '';

        $clase_terminados = '';
        $nav_terminados = '';

        $clase_generados = '';
        $nav_generados = '';

        $clase_archivados = '';
        $nav_archivados = '';
    }
@endphp

@extends('index')

@section('title', 'Mis tickets')

@section('css')

@endsection

@section('content')
<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol id="info-fill" fill="#fff" viewBox="0 0 16 16">
        <path
            d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
    </symbol>
</svg>

<div class="pagetitle">
    <h1>Mis tickets</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Vista general</a></li>
            <li class="breadcrumb-item active">Mis tickets</li>
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
                <div>
                    Hola, <span class="fw-bolder">{{ auth()->user()->nombre }}</span>! tienes <span id="countTickets">{{ $count }}</span> ticket(s)
                    abierto(s)
                </div>
            </div>

            <div class="card">
                <div class="card-body mt-3" id="contenidoTicket">
                    <a class="btn principal-button mb-3 new" data-bs-toggle="modal" data-bs-target="#formModal"> <i class="bi-plus-lg me-1"> </i>Abrir un nuevo ticket</a>
                    @if (auth()->user()->is_ps_gold || auth()->user()->is_ps_bronze)
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="generados-tab" data-bs-toggle="tab" data-bs-target="#generados-tab-pane" type="button" role="tab" aria-controls="generados-tab-pane" aria-selected="false">Tickets generados</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="generados-tab-pane" role="tabpanel" aria-labelledby="generados-tab" tabindex="0">
                                @foreach ($tickets_generado as $ticket_generado)
                                    <div class="col-lg-12 ps-3 pe-3">
                                        <div class="card border-0 mb-4 mt-4">
                                            <div class="flex-fill horizontal-card-bg-img2">
                                                <div class="card-body ticket_body">
                                                    <div>
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
                                                        <div class="font-weight-bold mt-3"><b>{{ $ticket_generado->asunto }}</b></div>
                                                        <div class="mb-3">
                                                            @if (strlen($ticket_generado->descripcion) >= 80)
                                                                {{ substr($ticket_generado->descripcion, 0, 80) }}...
                                                            @else
                                                                {{ substr($ticket_generado->descripcion, 0, 30) }}
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="boton_auto_ticket">
                                                        <a class="btn btn-sm btn-success edit" data-id="{{$ticket_generado->id}}" data-generado="{{$ticket_generado->usuarionombre}}" data-asignado="{{$ticket_generado->asignado_a}}" data-fechagenerado="{{$ticket_generado->fecha_generado}}" data-fechalimite="{{$ticket_generado->fecha_limite}}" data-departamento="{{$ticket_generado->departamento}}" data-asunto="{{$ticket_generado->asunto}}" data-descripcion="{{$ticket_generado->descripcion}}" data-status="{{$ticket_generado->status}}" title="Editar ticket">Editar ticket</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{$nav_abiertos}}" id="abiertos-tab" data-bs-toggle="tab" data-bs-target="#abiertos-tab-pane" type="button" role="tab" aria-controls="abiertos-tab-pane" aria-selected="true" data-opc="abiertos">Abiertos</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{$nav_procesos}}" id="proceso-tab" data-bs-toggle="tab" data-bs-target="#proceso-tab-pane" type="button" role="tab" aria-controls="proceso-tab-pane" aria-selected="false" data-opc="proceso">En proceso</button>
                            </li>                        
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{$nav_cancelados}}" id="cancelados-tab" data-bs-toggle="tab" data-bs-target="#cancelados-tab-pane" type="button" role="tab" aria-controls="cancelados-tab-pane" aria-selected="false" data-opc="cancelados">Cancelados</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{$nav_terminados}}" id="terminados-tab" data-bs-toggle="tab" data-bs-target="#terminados-tab-pane" type="button" role="tab" aria-controls="terminados-tab-pane" aria-selected="false" data-opc="atendidos">Atendidos</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{$nav_generados}}" id="generados-tab" data-bs-toggle="tab" data-bs-target="#generados-tab-pane" type="button" role="tab" aria-controls="generados-tab-pane" aria-selected="false" data-opc="generados">Generados</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{$nav_archivados}}" id="archivados-tab" data-bs-toggle="tab" data-bs-target="#archivados-tab-pane" type="button" role="tab" aria-controls="archivados-tab-pane" aria-selected="false" data-opc="archivados">Archivados</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade {{$clase_abiertos}}" id="abiertos-tab-pane" role="tabpanel" aria-labelledby="abiertos-tab" tabindex="0">
                                @foreach ($tickets_user_abiertos as $ticket_abierto)
                                    <div class="col-lg-12 ps-3 pe-3">
                                        <div class="card border-0 mb-4 mt-4">
                                            <div class="flex-fill horizontal-card-bg-img2">
                                                <div class="card-body ticket_body">
                                                    <div>
                                                        @if (Carbon\Carbon::now()->toDateTimeString() >= $ticket_abierto->fecha_limite)
                                                            @php
                                                                $now = Carbon\Carbon::now();
                                                                $limit = Carbon\Carbon::parse($ticket_abierto->fecha_limite);
                                                                $diff = $limit->diffForHumans();
                                                            @endphp
                                                            <span class="badge bg-danger mt-3"><i class="bi bi-info-circle-fill me-1"></i>Este ticket venció {{ $diff }}</span>
                                                        @endif
                                                        <div class="font-weight-bold mt-3"><b>{{ $ticket_abierto->asunto }}</b></div>
                                                        <div class="mb-3">
                                                            @if (strlen($ticket_abierto->descripcion) >= 80)
                                                                {{ substr($ticket_abierto->descripcion, 0, 80) }}...
                                                            @else
                                                                {{ substr($ticket_abierto->descripcion, 0, 30) }}
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="boton_auto_ticket">
                                                        <a class="mx-2 btn btn-sm principal-button detalles" data-id="{{$ticket_abierto->ticketid}}" data-generado="{{$ticket_abierto->usuarionombre}}" data-asignado="{{$ticket_abierto->asignado_a}}" data-fechagenerado="{{$ticket_abierto->fecha_generado}}" data-fechalimite="{{$ticket_abierto->fecha_limite}}" data-departamento="{{$ticket_abierto->departamento}}" data-asunto="{{$ticket_abierto->asunto}}" data-descripcion="{{$ticket_abierto->descripcion}}" data-status="{{$ticket_abierto->status}}" title="Ver detalles del ticket">Ver detalles del ticket</a>
                                                        <a class="mx-2 btn btn-sm btn-success status" data-id="{{$ticket_abierto->ticketid}}" data-status="{{$ticket_abierto->status}}" title="Ver detalles del ticket">Editar estatus</a>
                                                        <a class="mx-2 btn btn-sm btn-secondary traspasar" data-id="{{$ticket_abierto->ticketid}}" title="Transpasar ticket">Traspasar ticket</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="tab-pane fade {{$clase_procesos}}" id="proceso-tab-pane" role="tabpanel" aria-labelledby="proceso-tab" tabindex="0">
                                @foreach ($tickets_user_procesos as $ticket_proceso)
                                    <div class="col-lg-12 ps-3 pe-3">
                                        <div class="card border-0 mb-4 mt-4">
                                            <div class="flex-fill horizontal-card-bg-img2">
                                                <div class="card-body ticket_body">
                                                    <div>
                                                        @if (Carbon\Carbon::now()->toDateTimeString() >= $ticket_proceso->fecha_limite)
                                                            @php
                                                                $now = Carbon\Carbon::now();
                                                                $limit = Carbon\Carbon::parse($ticket_proceso->fecha_limite);
                                                                $diff = $limit->diffForHumans();
                                                            @endphp
                                                            <span class="badge bg-danger mt-3"><i class="bi bi-info-circle-fill me-1"></i>Este ticket venció {{ $diff }}</span>
                                                        @endif
                                                        <div class="font-weight-bold mt-3"><b>{{ $ticket_proceso->asunto }}</b></div>
                                                        <div class="mb-3">
                                                            @if (strlen($ticket_proceso->descripcion) >= 80)
                                                                {{ substr($ticket_proceso->descripcion, 0, 80) }}...
                                                            @else
                                                                {{ substr($ticket_proceso->descripcion, 0, 30) }}
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="boton_auto_ticket">
                                                        <a class="mx-2 btn btn-sm principal-button detalles" data-id="{{$ticket_proceso->ticketid}}" data-generado="{{$ticket_proceso->usuarionombre}}" data-asignado="{{$ticket_proceso->asignado_a}}" data-fechagenerado="{{$ticket_proceso->fecha_generado}}" data-fechalimite="{{$ticket_proceso->fecha_limite}}" data-departamento="{{$ticket_proceso->departamento}}" data-asunto="{{$ticket_proceso->asunto}}" data-descripcion="{{$ticket_proceso->descripcion}}" data-status="{{$ticket_proceso->status}}" title="Ver detalles del ticket">Ver detalles del ticket</a>
                                                        <a class="mx-2 btn btn-sm btn-success status" data-id="{{$ticket_proceso->ticketid}}" data-status="{{$ticket_proceso->status}}" title="Ver detalles del ticket">Editar estatus</a>
                                                        <a class="mx-2 btn btn-sm btn-secondary traspasar" data-id="{{$ticket_proceso->ticketid}}" title="Transpasar ticket">Traspasar ticket</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>                        
                            <div class="tab-pane fade {{$clase_cancelados}}" id="cancelados-tab-pane" role="tabpanel" aria-labelledby="cancelados-tab" tabindex="0">
                                @foreach ($tickets_user_cancelados as $ticket_cancelado)
                                    <div class="col-lg-12 ps-3 pe-3">
                                        <div class="card border-0 mb-4 mt-4">
                                            <div class="flex-fill horizontal-card-bg-img2">
                                                <div class="card-body ticket_body">
                                                    <div>
                                                        <span class="badge bg-warning text-dark mt-3"><i class="bi bi-info-circle-fill me-1"></i>Este ticket fue cancelado</span>
                                                        <div class="font-weight-bold mt-3"><b>{{ $ticket_cancelado->asunto }}</b></div>
                                                        <div class="mb-3">
                                                            @if (strlen($ticket_cancelado->descripcion) >= 80)
                                                                {{ substr($ticket_cancelado->descripcion, 0, 80) }}...
                                                            @else
                                                                {{ substr($ticket_cancelado->descripcion, 0, 30) }}
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="boton_auto_ticket">
                                                        <a class="mx-2 btn btn-sm principal-button detalles" data-id="{{$ticket_cancelado->ticketid}}" data-generado="{{$ticket_cancelado->usuarionombre}}" data-asignado="{{$ticket_cancelado->asignado_a}}" data-fechagenerado="{{$ticket_cancelado->fecha_generado}}" data-fechalimite="{{$ticket_cancelado->fecha_limite}}" data-departamento="{{$ticket_cancelado->departamento}}" data-asunto="{{$ticket_cancelado->asunto}}" data-descripcion="{{$ticket_cancelado->descripcion}}" data-status="{{$ticket_cancelado->status}}" title="Ver detalles del ticket">Ver detalles del ticket</a>
                                                        <a class="mx-2 btn btn-sm btn-success status" data-id="{{$ticket_cancelado->ticketid}}" data-status="{{$ticket_cancelado->status}}" title="Ver detalles del ticket">Editar estatus</a>
                                                        <a class="mx-2 btn btn-sm btn-secondary traspasar" data-id="{{$ticket_cancelado->ticketid}}" title="Transpasar ticket">Traspasar ticket</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="tab-pane fade {{$clase_terminados}}" id="terminados-tab-pane" role="tabpanel" aria-labelledby="terminados-tab" tabindex="0">
                                @foreach ($tickets_user_terminados as $ticket_terminado)
                                    <div class="col-lg-12 ps-3 pe-3">
                                        <div class="card border-0 mb-4 mt-4">
                                            <div class="flex-fill horizontal-card-bg-img2">
                                                <div class="card-body ticket_body">
                                                    <div>
                                                        <span class="badge bg-success mt-3"><i class="bi bi-info-circle-fill me-1"></i>Este ticket fue atendido con exito</span>
                                                        <div class="font-weight-bold mt-3"><b>{{ $ticket_terminado->asunto }}</b></div>
                                                        <div class="mb-3">
                                                            @if (strlen($ticket_terminado->descripcion) >= 80)
                                                                {{ substr($ticket_terminado->descripcion, 0, 80) }}...
                                                            @else
                                                                {{ substr($ticket_terminado->descripcion, 0, 30) }}
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="boton_auto_ticket">
                                                        <a class="btn btn-sm principal-button detalles" data-id="{{$ticket_terminado->ticketid}}" data-generado="{{$ticket_terminado->usuarionombre}}" data-asignado="{{$ticket_terminado->asignado_a}}" data-fechagenerado="{{$ticket_terminado->fecha_generado}}" data-fechalimite="{{$ticket_terminado->fecha_limite}}" data-departamento="{{$ticket_terminado->departamento}}" data-asunto="{{$ticket_terminado->asunto}}" data-descripcion="{{$ticket_terminado->descripcion}}" data-status="{{$ticket_terminado->status}}" title="Ver detalles del ticket">Ver detalles del ticket</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="tab-pane fade {{$clase_generados}}" id="generados-tab-pane" role="tabpanel" aria-labelledby="generados-tab" tabindex="0">
                                @foreach ($tickets_generado as $ticket_generado)
                                    <div class="col-lg-12 ps-3 pe-3">
                                        <div class="card border-0 mb-4 mt-4">
                                            <div class="flex-fill horizontal-card-bg-img2">
                                                <div class="card-body ticket_body">
                                                    <div>
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
                                                        <div class="font-weight-bold mt-3"><b>{{ $ticket_generado->asunto }}</b></div>
                                                        <div class="mb-3">
                                                            @if (strlen($ticket_generado->descripcion) >= 80)
                                                                {{ substr($ticket_generado->descripcion, 0, 80) }}...
                                                            @else
                                                                {{ substr($ticket_generado->descripcion, 0, 30) }}
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="boton_auto_ticket">
                                                        <a class="btn btn-sm btn-success edit" data-id="{{$ticket_generado->id}}" data-generado="{{$ticket_generado->usuarionombre}}" data-asignado="{{$ticket_generado->asignado_a}}" data-fechagenerado="{{$ticket_generado->fecha_generado}}" data-fechalimite="{{$ticket_generado->fecha_limite}}" data-departamento="{{$ticket_generado->departamento}}" data-asunto="{{$ticket_generado->asunto}}" data-descripcion="{{$ticket_generado->descripcion}}" data-status="{{$ticket_generado->status}}" title="Editar ticket">Editar ticket</a>
                                                        <a class="btn btn-sm btn-secondary archivar" data-id="{{$ticket_generado->id}}" data-archivado="si" title="Archivar ticket">Archivar</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="tab-pane fade {{$clase_archivados}}" id="archivados-tab-pane" role="tabpanel" aria-labelledby="archivados-tab" tabindex="0">
                                @foreach ($tickets_archivado as $ticket_archivado)
                                    <div class="col-lg-12 ps-3 pe-3">
                                        <div class="card border-0 mb-4 mt-4">
                                            <div class="flex-fill horizontal-card-bg-img2">
                                                <div class="card-body ticket_body">
                                                    <div>
                                                        @if (Carbon\Carbon::now()->toDateTimeString() >= $ticket_archivado->fecha_limite)
                                                            @php
                                                                $now = Carbon\Carbon::now();
                                                                $limit = Carbon\Carbon::parse($ticket_archivado->fecha_limite);
                                                                $diff = $limit->diffForHumans();
                                                            @endphp
                                                            @if ($ticket_archivado->status == "Abierto" || $ticket_archivado->status == "En proceso")
                                                                <span class="badge bg-danger mt-3"><i class="bi bi-info-circle-fill me-1"></i>Este ticket venció {{ $diff }} y no fue atendido ni cancelado</span>
                                                            @elseif($ticket_archivado->status == "Cancelado")
                                                                <span class="badge bg-warning text-dark mt-3"><i class="bi bi-info-circle-fill me-1"></i>Este ticket fue cancelado</span>
                                                            @elseif($ticket_archivado->status == "Terminado")
                                                                <span class="badge bg-success mt-3"><i class="bi bi-info-circle-fill me-1"></i>Este ticket fue atendido con exito</span>
                                                            @endif
                                                        @else
                                                            @if ($ticket_archivado->status == "Abierto")
                                                                <span class="badge bg-success mt-3"><i class="bi bi-info-circle-fill me-1"></i>Este ticket está abierto</span>
                                                            @elseif($ticket_archivado->status == "En proceso")
                                                                <span class="badge bg-success mt-3"><i class="bi bi-info-circle-fill me-1"></i>Este ticket está en proceso</span>
                                                            @elseif($ticket_archivado->status == "Cancelado")
                                                                <span class="badge bg-warning text-dark mt-3"><i class="bi bi-info-circle-fill me-1"></i>Este ticket fue cancelado</span>
                                                            @elseif($ticket_archivado->status == "Terminado")
                                                                <span class="badge bg-success mt-3"><i class="bi bi-info-circle-fill me-1"></i>Este ticket fue atendido con exito</span>
                                                            @endif
                                                        @endif
                                                        <div class="font-weight-bold mt-3"><b>{{ $ticket_archivado->asunto }}</b></div>
                                                        <div class="mb-3">
                                                            @if (strlen($ticket_archivado->descripcion) >= 80)
                                                                {{ substr($ticket_archivado->descripcion, 0, 80) }}...
                                                            @else
                                                                {{ substr($ticket_archivado->descripcion, 0, 30) }}
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="boton_auto_ticket">
                                                        <a class="btn btn-sm btn-success edit" data-id="{{$ticket_archivado->id}}" data-generado="{{$ticket_archivado->usuarionombre}}" data-asignado="{{$ticket_archivado->asignado_a}}" data-fechagenerado="{{$ticket_archivado->fecha_generado}}" data-fechalimite="{{$ticket_archivado->fecha_limite}}" data-departamento="{{$ticket_archivado->departamento}}" data-asunto="{{$ticket_archivado->asunto}}" data-descripcion="{{$ticket_archivado->descripcion}}" data-status="{{$ticket_archivado->status}}" title="Editar ticket">Editar ticket</a>
                                                        <a class="btn btn-sm btn-secondary desarchivar" data-id="{{$ticket_archivado->id}}" data-archivado="no" title="Desarchivar ticket">Desarchivar</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Abrir un ticket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="ticketForm" method="post">
                    @csrf
                    <input type="hidden" name="id" id="idInput">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-3">
                                <select name="departamento" class="form-control" id="departamentoInput" required>
                                    <option value="" disabled selected>Selecciona...</option>
                                    <option value="Administración">Administración</option>
                                    <option value="Contabilidad">Contabilidad</option>
                                    <option value="Egresos">Egresos</option>
                                    <option value="Sistemas">Sistemas</option>
                                </select>
                                <label for="asignadoAInput">Departamento dirigido</label>
                            </div>
                        </div>                        
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-3">
                                <select name="asignado_a" pattern="[a-zA-Zá-úÁ-Ú ]+" class="form-control" id="asignadoAInput" required>
                                    <option value="" disabled selected>Selecciona...</option>
                                </select>
                                <label for="asignadoAInput">Asignar a</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-3">
                                <input type="datetime-local" class="form-control"
                                    placeholder="Selecciona la fecha actual" id="fechaActualInput" name="fecha_actual"
                                    disabled value="{{\Carbon\Carbon::now()->format("Y-m-d H:i")}}">
                                <label for="fechaActualInput">Fecha de generación</label>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-3">
                                <input type="datetime-local" class="form-control"
                                    placeholder="Selecciona la fecha límite" id="fechaLimiteInput" name="fecha_limite"
                                    required>
                                <label for="fechaLimiteInput">Fecha límite para atender el ticket</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-floating mb-3">
                                <input style="text-transform: none !important" type="text" class="form-control" placeholder="Ingresa el asunto del ticket" id="asuntoInput" name="asunto" required>
                                <label for="asuntoInput">Asunto del ticket</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-floating mb-3">
                            <textarea class="form-control" placeholder="Ingresa la descripción del ticket" id="descripcionInput" name="descripcion" style="height: 250px; text-transform: none !important;" required></textarea>
                            <label for="descripcionInput" class="ps-4">Descripción del ticket</label>
                        </div>
                    </div>
                    <div style="display:block !important" id="alertMessage" class="invalid-feedback"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="btnCancel"
                            data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn principal-button" id="btnSubmit">Abrir ticket</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detallesModal" tabindex="-1" aria-labelledby="detallesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detalles del ticket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 col-12 mb-2">
                        <b>Asignado a</b>: <span>{{ auth()->user()->nombre }} {{ auth()->user()->apellido_p }} {{ auth()->user()->apellido_m }}</span>
                    </div>
                    <div class="col-md-6 col-12 mb-2">
                        <b>Departamento</b>: <span id="departamento"></span>
                    </div>

                    <div class="col-md-6 col-12 mb-2">
                        <b>Generado por</b>: <span id="generado"></span>
                    </div>
                    <div class="col-md-6 col-12 mb-2">
                        <b>Estatus</b>: <span id="estatus"></span>
                    </div>

                    <div class="col-md-6 col-12 mb-2">
                        <b>Fecha generado</b>: <span id="fecha_generado"></span>
                    </div>
                    <div class="col-md-6 col-12 mb-2">
                        <b>Fecha limite</b>: <span id="fecha_limite"></span>
                    </div>
                    
                    <div class="col-12 mb-2">
                        <b>Asunto</b>: <span id="asunto"></span>
                    </div>
                    <div class="col-12 mb-2">
                        <b>Descripción</b>: <span id="descripcion"></span>
                    </div>
                    
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingUs">
                                <button id="collapseBtn" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUs" aria-expanded="false" aria-controls="collapseUs">
                                    <b>Desplegar para ver el historial de traspasos</b>
                                </button>
                            </h2>
                            <div id="collapseUs" class="accordion-collapse collapse" aria-labelledby="headingUs"
                                data-bs-parent="#accordionUs">
                                <div class="accordion-body">
                                    <div class="row" id="historial"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEstatusTitle">Editar el estatus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="ticketEstatusForm" method="post">
                    @csrf
                    <input type="hidden" name="id" id="idEstatusInput">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-floating mb-3">
                                <select name="status" class="form-control" id="statusInput" required>
                                    <option value="" disabled selected>Selecciona...</option>
                                    <option value="Abierto">Abierto</option>
                                    <option value="En proceso">En proceso</option>
                                    <option value="Cancelado">Cancelado</option>
                                    <option value="Terminado">Atendido</option>
                                </select>
                                <label for="statusInput">Estatus</label>
                            </div>
                        </div>
                    </div>
                    <div style="display:block !important" id="alertEstatusMessage" class="invalid-feedback"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="btnEstatusCancel"
                            data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn principal-button" id="btnEstatusSubmit">Editar estatus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="traspasarModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Traspasar ticket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="traspasarForm" method="post">
                    @csrf
                    <input type="hidden" name="id" id="idTraspasarInput">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-3">
                                <select name="departamento" class="form-control" id="departamentoTrasInput" required>
                                    <option value="" disabled selected>Selecciona...</option>
                                    <option value="Administración">Administración</option>
                                    <option value="Contabilidad">Contabilidad</option>
                                    <option value="Egresos">Egresos</option>
                                    <option value="Sistemas">Sistemas</option>
                                </select>
                                <label for="departamentoTrasInput">Departamento dirigido</label>
                            </div>
                        </div>                        
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-3">
                                <select name="asignado_a" class="form-control" id="asignadoATrasInput" required>
                                    <option value="" disabled selected>Selecciona...</option>
                                </select>
                                <label for="asignadoATrasInput">Asignar a</label>
                            </div>
                        </div>
                    </div>
                    <div style="display:block !important" id="alertTrasMessage" class="invalid-feedback"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="btnTrasCancel" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn principal-button" id="btnTrasSubmit">Traspasar ticket</button>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/locale/es.js"></script>
<script src="{{ asset('js/ticket.js') }}"></script>
@endsection