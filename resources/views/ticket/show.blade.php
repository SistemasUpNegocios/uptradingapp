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
                    Hola, <span class="fw-bolder">{{ auth()->user()->nombre }}</span>! tienes {{ $count }} ticket(s)
                    abierto(s)
                </div>
            </div>

            <div class="card">
                <div class="card-body mt-3">
                    <a class="btn principal-button mb-3 new" data-bs-toggle="modal" data-bs-target="#formModal"> <i
                            class="bi-plus-lg me-1"> </i>Abrir un nuevo ticket</a>

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="abiertos-tab" data-bs-toggle="tab"
                                data-bs-target="#abiertos-tab-pane" type="button" role="tab"
                                aria-controls="abiertos-tab-pane" aria-selected="true">Abiertos</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                data-bs-target="#profile-tab-pane" type="button" role="tab"
                                aria-controls="profile-tab-pane" aria-selected="false">En proceso</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="contact-tab" data-bs-toggle="tab"
                                data-bs-target="#contact-tab-pane" type="button" role="tab"
                                aria-controls="contact-tab-pane" aria-selected="false">Terminados</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="contact-tab" data-bs-toggle="tab"
                                data-bs-target="#contact-tab-pane" type="button" role="tab"
                                aria-controls="contact-tab-pane" aria-selected="false">Cancelados</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="abiertos-tab-pane" role="tabpanel"
                            aria-labelledby="abiertos-tab" tabindex="0">
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

                                                <span class="badge bg-warning text-dark mt-3"><i class="bi bi-info-circle-fill me-1"></i>Este ticket venció {{ $diff }}</span>
                                                @else
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

                                        <div
                                            class="horizontal-card-btn-container d-flex justify-content-center align-items-center">
                                            <a class="btn btn-sm principal-button me-2 showLista" data-id=""
                                                title="Ver los pendientes de ">Ver detalles del ticket</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab"
                            tabindex="0">...</div>
                        <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab"
                            tabindex="0">...</div>
                        <div class="tab-pane fade" id="disabled-tab-pane" role="tabpanel" aria-labelledby="disabled-tab"
                            tabindex="0">...</div>
                    </div>
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
                        <div class="col-12">
                            <div class="form-floating mb-3">
                                <select name="asignado_a" pattern="[a-zA-Zá-úÁ-Ú ]+" class="form-control"
                                    id="asignadoAInput" required>
                                    <option value="" disabled selected>Selecciona..</option>
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->apellido_p }} {{
                                        $user->apellido_m }} {{ $user->nombre }}</option>
                                    @endforeach
                                </select>
                                <label for="asignadoAInput">Asignar a</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-3">
                                <input type="datetime-local" class="form-control"
                                    placeholder="Selecciona la fecha límite" id="fechaLimiteInput" name="fecha_limite"
                                    required>
                                <label for="fechaLimiteInput">Fecha límite para atender el ticket</label>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-3">
                                <select name="departamento" class="form-control" id="departamentoInput" required>
                                    <option value="" disabled selected>Selecciona..</option>
                                    <option value="Administración">Administración</option>
                                    <option value="Contaduría">Contaduría</option>
                                    <option value="Egresos">Egresos</option>
                                    <option value="Sistemas">Sistemas</option>
                                    <option value="General">General</option>
                                </select>
                                <label for="asignadoAInput">Departamento dirigido</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" placeholder="Ingresa el asunto del ticket"
                                    id="asuntoInput" name="asunto" required>
                                <label for="asuntoInput">Asunto del ticket</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-floating mb-3">
                            <textarea type="text" class="form-control" placeholder="Ingresa la descripción del ticket"
                                id="descripcionInput" name="descripcion" style="height: 150px" required></textarea>
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
<script src="{{ asset('js/ticket.js') }}"></script>
@endsection