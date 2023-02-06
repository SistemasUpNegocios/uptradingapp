@extends('index')

@section('title', 'Gestión de pendientes')

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/@jarstone/dselect/dist/css/dselect.css">
@endsection

@section('content')
    <div class="pagetitle">
        <h1>Checklist de nuevos clientes</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Vista general</a></li>
                <li class="breadcrumb-item active">Checklist de nuevos clientes</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body mt-3">
                        <a class="btn principal-button mb-3 new" data-bs-toggle="modal" data-bs-target="#formModal"> <i class="bi-plus-lg me-1"> </i>Añadir una nueva lista de pendientes</a>
                        <a class="btn principal-button mb-3 btn-volver d-none"> <i class="bi-chevron-left me-1"></i>Volver a ver a los clientes</a>
                        <form id="listaForm" action="/admin/editPendiente" method="post">
                            @csrf
                            <div id="contPendientes" style="overflow-x: scroll; max-height: 70vh">
                                @foreach ($pendientes as $pendiente)
                                    <div class="col-lg-12 ps-3 pe-3">
                                        <div class="card border-0 mb-4 mt-4">
                                            <div class="row align-items-center pb-3 pt-3">
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="horizontal-card-bg-img"></div>
                                                    <div class="flex-fill">
                                                        <div class="card-body">
                                                            <div class="font-weight-bold"><b>Lista de {{ $pendiente->memo_nombre }}</b></div>
                                                            <div>Última modificación {{Carbon\Carbon::parse($pendiente->ultima_modificacion)->diffForHumans() }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6 col-sm-12 d-flex justify-content-center">
                                                    <div class="horizontal-card-btn-container">
                                                        <a class="btn btn-sm btn-primary me-2 showLista" data-id="{{ $pendiente->pendienteid }}" title="Ver los pendientes de {{ $pendiente->memo_nombre }}">Ver pendientes</a>
                                                        <a class="btn btn-sm btn-danger delete" data-id="{{ $pendiente->pendienteid }}" title="Eliminar los pendientes de {{ $pendiente->memo_nombre }}"><i class="bi bi-trash"></i></a>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Añadir lista de pendientes</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="pendienteForm" method="post">
                        @csrf
                        <input type="hidden" name="id" id="idInput">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" minlength="3" maxlength="150" title="Ej: A.Paterno A.Materno Nombre" placeholder="Ingresa el nombre del cliente" id="nombreInput" name="nombre" required>
                                    <label for="nombreInput">Nombre del cliente</label>
                                </div>
                                <span class="badge bg-danger mb-3" id="nomError">Error</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <select name="ps_id" minlength="3" maxlength="120" pattern="[a-zA-Zá-úÁ-Ú ]+"
                                        class="form-select selectSearch" id="psIdInput">
                                        <option value="" disabled selected>Selecciona..</option>
                                        @foreach($lista_ps as $ps)
                                        <option value="{{ $ps->id }}">{{ $ps->nombre }} {{ $ps->apellido_p }} {{
                                            $ps->apellido_m }}</option>
                                        @endforeach
                                    </select>
                                    <label for="psIdInput">PS</label>
                                </div>
                            </div>
                        </div>
                        <div id="alertMessage"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="btnCancel" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn principal-button" id="btnSubmit">Añadir lista</button>
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
    <script src="https://unpkg.com/@jarstone/dselect/dist/js/dselect.js"></script>
    <script src="{{ asset('js/pendiente.js') }}"></script>
@endsection