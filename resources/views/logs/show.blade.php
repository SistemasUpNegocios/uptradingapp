@extends('index')

@section('title', 'Historial de cambios')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="https://unpkg.com/@jarstone/dselect/dist/css/dselect.css">
@endsection

@section('content')
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="info-fill" fill="#fff" viewBox="0 0 16 16">
            <path
                d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
        </symbol>
    </svg>

    <div class="pagetitle">
        <h1>Historial de cambios</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Vista general</a></li>
                <li class="breadcrumb-item active">Historial de cambios</li>
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
                        Registro de cambios en todos los módulos del sistema, presiona <b>Ver más detalles</b> para consultar la información completa
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body mt-3">
                        <table class="table table-striped table-bordered nowrap text-center" style="width: 100%" id="cambios">
                            <thead>
                                <tr>
                                    <th data-priority="0" scope="col">Tipo de acción</th>
                                    <th data-priority="0" scope="col">Tabla</th>
                                    <th data-priority="0" scope="col">Usuario</th>
                                    <th data-priority="0" scope="col">Fecha y hora</th>
                                    <th data-priority="0" scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="cambiosBody">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="detallesModal" tabindex="-1" aria-labelledby="detallesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detalles de los cambios al sistema</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-primary d-flex align-items-center" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                            <use xlink:href="#info-fill" />
                        </svg>
                        <div>
                            Detalles del usuario
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-12 mb-2">
                            <b>Dirección IP</b>: <span id="ip"></span>
                        </div>
                        <div class="col-md-6 col-12 mb-2">
                            <b>Fecha de entrada</b>: <span id="fe"></span>
                        </div>
                        <div class="col-md-6 col-12 mb-2">
                            <b>Fecha de salida</b>: <span id="fs"></span>
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
                            <b>Acción</b>: <span id="acc"></span>
                        </div>
                        <div class="col-md-6 col-12 mb-2">
                            <b>Tabla</b>: <span id="tab"></span>
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
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://unpkg.com/@jarstone/dselect/dist/js/dselect.js"></script>
    <script src="{{ asset('js/logs.js') }}"></script>
@endsection