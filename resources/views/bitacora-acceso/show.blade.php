@extends('index')

@section('title', 'Bitacora de accesos al sistema')

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
        <h1>Bitacora de accesos al sistema</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Vista general</a></li>
                <li class="breadcrumb-item active">Bitacora de accesos al sistema</li>
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
                        Registro de inicios de sesión en el sistema, presiona <b>Ver más detalles</b> para consultar la
                        información completa
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body mt-3 overflow-auto" style="height: 55vh !important;">
                        @foreach ($bitacoras as $bitacora)
                        @php
                        $fecha_inicio = \Carbon\Carbon::parse($bitacora->fecha_entrada);
                        $fecha_fin = \Carbon\Carbon::parse($bitacora->fecha_salida);
                        $dif_fechas = $fecha_inicio->diffForHumans($fecha_fin, true, false);
                        @endphp
                        @if (\Carbon\Carbon::parse($bitacora->fecha_salida) > \Carbon\Carbon::now())
                        <div class="card shadow-sm mt-2 pt-3" id="statusActivo">
                            <div class="card-body w-100">
                                <div class="row d-flex justify-content-between">
                                    <div class="col-md-10 col-12">
                                        <p class="card-text">El usuario <b>{{ $bitacora->user_nombre }}</b> inició una
                                            sesión desde un/una {{ lcfirst($bitacora->dispositivo) }} desde la IP <b>{{
                                                $bitacora->direccion_ip }}</b> </p>
                                    </div>
                                    <div class="col-md-2 col-12">
                                        <a href="#" class="btn btn-sm principal-button verDetalles"
                                            data-id="{{ $bitacora->id }}" data-bs-toggle="modal"
                                            data-bs-target="#detallesModal">Ver más detalles</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-muted p-0 ps-3 pt-2 pb-2">
                                {{ \Carbon\Carbon::parse($bitacora->fecha_entrada)->diffForHumans() }}
                            </div>
                        </div>
                        @else
                        <div class="card shadow-sm mt-2 pt-3" id="statusInactivo">
                            <div class="card-body w-100">
                                <div class="row d-flex justify-content-between">
                                    <div class="col-md-10 col-12">
                                        <p class="card-text">El usuario <b>{{ $bitacora->user_nombre }}</b> tuvo una
                                            sesión desde un/una {{ lcfirst($bitacora->dispositivo) }} que duró {{
                                            $dif_fechas }} desde la IP <b>{{
                                                $bitacora->direccion_ip }}</b> </p>
                                    </div>
                                    <div class="col-md-2 col-12">
                                        <a href="#" class="btn btn-sm principal-button verDetalles"
                                            data-id="{{ $bitacora->id }}" data-bs-toggle="modal"
                                            data-bs-target="#detallesModal">Ver más detalles</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-muted p-0 ps-3 pt-2 pb-2">
                                {{ \Carbon\Carbon::parse($bitacora->fecha_entrada)->diffForHumans() }}
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="detallesModal" tabindex="-1" aria-labelledby="detallesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detalles del acceso al sistema</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-primary d-flex align-items-center" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                            <use xlink:href="#info-fill" />
                        </svg>
                        <div>
                            Detalles de la sesión
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-12 mb-2">
                            <b>Dirección IP</b>: <span id="ip"></span>
                        </div>
                        <div class="col-md-6 col-12 mb-2">
                            <b>Tipo de dispositivo</b>: <span id="td"></span>
                        </div>
                        <div class="col-md-6 col-12 mb-2">
                            <b>Sistema operativo</b>: <span id="so"></span>
                        </div>
                        <div class="col-md-6 col-12 mb-2">
                            <b>Navegador</b>: <span id="br"></span>
                        </div>
                        <div class="col-md-6 col-12 mb-2">
                            <b>Fecha de entrada</b>: <span id="fe"></span>
                        </div>
                        <div class="col-md-6 col-12 mb-2">
                            <b>Fecha de salida</b>: <span id="fs"></span>
                        </div>                        

                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingUs">
                                    <button id="collapseBtn" class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseUs" aria-expanded="false"
                                        aria-controls="collapseUs">
                                    </button>
                                </h2>
                                <div id="collapseUs" class="accordion-collapse collapse" aria-labelledby="headingUs"
                                    data-bs-parent="#accordionUs">
                                    <div class="accordion-body">
                                        <div class="row align-items-center justify-content-center">
                                            <div class="col-md-6 col-12 mb-2 text-center">
                                                <img src="" id="imgPerfil" alt="" srcset="">
                                            </div>
                                            <div class="col-md-6 col-12 mb-2">
                                                    <div class="mb-2">
                                                    <b>Nombre</b>: <span id="no"></span>
                                                    </div>
                                                    <div class="mb-2">
                                                        <b>Apellido paterno</b>: <span id="ap"></span>
                                                    </div>
                                                    <div class="mb-2">
                                                        <b>Apellido materno</b>: <span id="am"></span>
                                                    </div>
                                                    <div class="mb-2">
                                                        <b>Correo electrónico</b>: <span id="ce"></span>
                                                    </div>
                                                    <div class="mb-2">
                                                        <b>Privilegio</b>: <span id="pr"></span>
                                                    </div>
                                            </div>
                                        </div>
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
    <script src="{{ asset('js/bitacoraAcceso.js') }}"></script>
@endsection