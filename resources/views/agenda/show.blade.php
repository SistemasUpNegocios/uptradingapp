@extends('index')

@section('title', 'Agenda')

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.6.0/main.css">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.6.0/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.6.0/locales-all.js"></script>
@endsection

@section('content')
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="info-fill" fill="#fff" viewBox="0 0 16 16">
            <path
                d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
        </symbol>
    </svg>

    <div class="pagetitle">
        <h1>Agenda</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Vista general</a></li>
                <li class="breadcrumb-item active">Agenda</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="alert alert-primary d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                        <use xlink:href="#info-fill" />
                    </svg>
                    <div>
                        Para agregar una cita solo debes hacer click en una fecha, para editar y/o borrar hacer click sobre cada cita.
                    </div>
                </div>
                <div class="card">
                    <div class="card-body mt-3">
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="form-floating">
                                    <select name="ver_citas" class="form-control" id="verCitasInput" required style="text-transform: none !important;">
                                        <option value="all" selected>Todas</option>
                                        <option value="asignada_a" >Asignadas a mí</option>
                                        <option value="generado_por" >Creadas por mí</option>
                                    </select>
                                    <label for="verCitasInput">Ver citas</label>
                                </div>
                            </div>
                        </div>
                        <div id="agenda" name="agenda"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Añadir un cita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="agendaForm" method="post">
                        @csrf
                        <input type="hidden" name="id" id="idInput">
                        <input type="hidden" id="id_user" value="{{ auth()->user()->id }}">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" placeholder="Ingresa el titulo de la cita" id="tituloInput" name="titulo" required style="text-transform: none !important;">
                                    <label for="tituloInput">Titulo</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <textarea type="text" class="form-control" placeholder="Ingresa la descripcion de la cita" id="descripcionInput" name="descripcion" style="height: 150px; text-transform: none !important;"></textarea>
                                    <label for="descripcionInput">Descripción</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" id="fechaInput" name="fecha" required readonly>
                                    <label for="fechaInput">Fecha</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="time" class="form-control" id="horaInput" name="hora" required>
                                    <label for="horaInput">Hora</label>
                                </div>
                            </div>                            
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12 mb-3">
                                <div class="form-floating">
                                    <select name="asignado_a" class="form-control" id="asignadoAInput" required style="text-transform: none !important;">
                                        <option value="" disabled selected>Selecciona..</option>
                                        @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos)
                                            @foreach($users as $user)
                                            <option value="{{ $user->id }}"> {{ $user->nombre }} {{ $user->apellido_p }} {{ $user->apellido_m }}</option>
                                            @endforeach                                            
                                        @elseif(auth()->user()->is_ps_gold || auth()->user()->is_ps_bronze)
                                            <option value="{{ auth()->user()->id }}"> {{ auth()->user()->nombre }} {{ auth()->user()->apellido_p }} {{ auth()->user()->apellido_m }}</option>
                                        @endif
                                    </select>
                                    <label for="asignadoAInput">Asignar a</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <div class="form-floating">
                                    <input type="color" class="form-control" name="color" id="colorInput" value="#01bbcc" required>                                
                                    <label for="asignadoAInput" style="margin-top: -3px">Color</label>
                                </div>
                            </div>
                        </div>
                        @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos)
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <div class="form-floating">
                                        <select name="asignado_a2" class="form-control" id="asignadoA2Input" style="text-transform: none !important;">
                                            <option value="" disabled selected>Selecciona..</option>
                                            @foreach($users as $user)
                                            <option value="{{ $user->id }}"> {{ $user->nombre }} {{ $user->apellido_p }} {{ $user->apellido_m }}</option>
                                            @endforeach
                                        </select>
                                        <label for="asignadoAInput">Asignar también a</label>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div style="display:block !important" id="alertMessage" class="invalid-feedback"></div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="btnGuardar">Guardar</button>
                            <button type="submit" class="btn btn-success" id="btnModificar">Modificar</button>
                            <button type="button" class="btn btn-danger" id="btnEliminar">Eliminar</button>
                            <button type="button" class="btn btn-secondary" id="btnCerrar">Cerrar</button>
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
    <script src="{{ asset('js/agenda.js') }}" defer></script>
@endsection