@extends('index')

@section('title', 'Gestión de documentos')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css">    
@endsection

@section('content')
    <div class="pagetitle">
        <h1>Gestión de documentos</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Vista general</a></li>
                <li class="breadcrumb-item active">Gestión de documentos</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body mt-3">
                        @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos)
                            <a class="btn principal-button mb-3 new" data-bs-toggle="modal" data-bs-target="#formModal"> <i class="bi-plus-lg me-1"> </i>Añadir un nuevo documento</a>
                        @endif
                        <div>
                            <ol class="ps-3 mt-2">
                                <div class="ps-2 row align-items-center mb-2" id="contenedorDocumentos">  
                                    @foreach ($documentos as $documento)
                                        @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos)
                                            <li>
                                                <div class="ps-2 row align-items-center mb-2">
                                                    <div class="col-12 col-md-6 col-sm-6 col-xs-6"><p>{{ $documento->nombre }} ({{ $documento->tipo_documento }})</p></div>
                                                    <div class="col-12 col-md-6 col-sm-6 col-xs-6 text-end accion_documentos">
                                                        <a href="" data-id="{{ $documento->id }}" data-tipo="{{ $documento->tipo_documento }}" data-nombre="{{ $documento->nombre }}" data-documento="{{ $documento->documento }}" type="button" title="Vista previa" class="btn btn-primary btn-sm btn-icon view"> <i class="bi bi-eye"></i></a>
                                                        <a href="" data-id="{{ $documento->id }}" data-tipo="{{ $documento->tipo_documento }}" data-nombre="{{ $documento->nombre }}" data-documento="{{ $documento->documento }}" type="button" title="Editar documento" class="btn btn-success btn-sm btn-icon edit"> <i class="bi bi-pencil"></i></a>
                                                        <a href="" data-id="{{ $documento->id }}" type="button" title="Eliminar documento" class="btn btn-danger btn-sm btn-icon delete"> <i class="bi bi-trash"></i></a>
                                                        <a href="{{ "../documentos/$documento->tipo_documento/$documento->documento" }}" download="{{ $documento->documento }}" title="Descargar {{ $documento->nombre }}" class="btn btn-secondary btn-sm btn-icon download"><i class="bi bi-download"></i></a>
                                                    </div>
                                                </div>
                                            </li>
                                        @elseif (auth()->user()->is_cliente && $documento->tipo_documento == "cliente")
                                            <li>
                                                <div class="ps-2 row align-items-center mb-2">
                                                    <div class="col-md-6"><p>{{ $documento->nombre }}</p></div>
                                                    <div class="col-md-6 text-end accion_documentos">
                                                        <a href="{{ "../documentos/$documento->tipo_documento/$documento->documento" }}" download="{{ $documento->documento }}" title="Descargar {{ $documento->nombre }}" class="btn btn-secondary btn-lg btn-icon download"><i class="bi bi-download"></i></a>
                                                    </div>
                                                </div>
                                            </li>
                                        @elseif (auth()->user()->is_ps_gold || auth()->user()->is_ps_bronze || auth()->user()->is_egresos || auth()->user()->is_ps_diamond)
                                            <li>
                                                <div class="ps-2 row align-items-center mb-2">
                                                    <div class="col-md-6"><p>{{ $documento->nombre }} ({{ $documento->tipo_documento }})</p></div>
                                                    <div class="col-md-6 text-end accion_documentos">
                                                        <a href="" data-id="{{ $documento->id }}" data-tipo="{{ $documento->tipo_documento }}" data-nombre="{{ $documento->nombre }}" data-documento="{{ $documento->documento }}" type="button" title="Vista previa" class="btn btn-primary btn-sm btn-icon view"> <i class="bi bi-eye"></i></a>
                                                        <a href="{{ "../documentos/$documento->tipo_documento/$documento->documento" }}" download="{{ $documento->documento }}" title="Descargar {{ $documento->nombre }}" class="btn btn-secondary btn-lg btn-icon download"><i class="bi bi-download"></i></a>
                                                    </div>
                                                </div>
                                            </li>
                                        @endif
                                    @endforeach
                                </div>
                            </ol>
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
                    <h5 class="modal-title" id="modalTitle">Añadir documento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="documentoForm" method="post">
                        @csrf
                        <input type="hidden" name="id" id="idInput">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" placeholder="Ingresa el nombre del documento" id="nombreInput" name="nombre" required style="text-transform: none !important;">
                                    <label for="redaccionInput">Nombre del documento</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <select name="tipo_documento" class="form-control" id="tipoInput" required>
                                        <option value="" disabled selected>Selecciona...</option>
                                        <option value="swissquote">Swissquote</option>
                                        <option value="uptrading">Uptrading</option>
                                        <option value="cliente">Cliente</option>
                                    </select>
                                    <label for="tipoInput">Tipo de documento</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">                    
                            <div class="col-12 mb-3">
                                <div class="d-flex justify-content-between">
                                    <label for="documentoInput" class="form-label">Documento</label>
                                    <a id="documentoDescModal" class="d-none fs-5 text-secondary"><i class="bi bi-download"></i></a>
                                </div>
                                <input type="file" id="documentoInput" class="form-control" name="documento" required>
                            </div>                        
                        </div>
                        <div id="alertMessage"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="btnCancel" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn principal-button" id="btnSubmit">Añadir documento</button>
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
    <script src="{{ asset('js/documento.js') }}"></script>
@endsection