@extends('index')

@section('title', 'Gestión de notas MAM')

@section('css')
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/@jarstone/dselect/dist/css/dselect.css">
    <style>
        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 0 solid transparent;
            border-radius: 0;
        }
        .card-body {
            flex: 1 1 auto;
            padding: 1.57rem;
        }
    </style>
@endsection

@section('content')
    <div class="pagetitle">
        <h1>Gestión de notas MAM</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Vista general</a></li>
                <li class="breadcrumb-item active">Gestión de notas MAM</li>
            </ol>
        </nav>
    </div>

    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="info-fill" fill="#fff" viewBox="0 0 16 16">
            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
        </symbol>
    </svg>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body mt-3">
                        <div class="page-content container note-has-grid">
                            <ul class="nav nav-pills p-3 bg-white mb-3 rounded-pill align-items-center">
                                <li class="nav-item">
                                    <a href="javascript:void(0)" class="nav-link rounded-pill note-link d-flex align-items-center px-2 px-md-3 me-0 mr-md-2 active" id="all-category">
                                        <i class="icon-layers me-1"></i><span class="d-none d-md-block">Todas las notas</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="javascript:void(0)" class="nav-link rounded-pill note-link d-flex align-items-center px-2 px-md-3 me-0 mr-md-2" id="note-pendientes"> <i class="icon-briefcase me-1"></i><span class="d-none d-md-block">Pendientes de carga</span></a>
                                </li>
                                <li class="nav-item">
                                    <a href="javascript:void(0)" class="nav-link rounded-pill note-link d-flex align-items-center px-2 px-md-3 me-0 mr-md-2" id="note-cargados"> <i class="icon-share-alt me-1"></i><span class="d-none d-md-block">Cargados</span></a>
                                </li>
                                @if(auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_ps_gold || auth()->user()->is_ps_bronze || auth()->user()->is_ps_diamond)
                                    <li class="nav-item ml-auto">
                                        <a href="javascript:void(0)" class="nav-link btn-primary rounded-pill d-flex align-items-center px-3" id="add-notes"> <i class="icon-note m-1"></i><span class="d-none d-md-block font-14">Añadir nota</span></a>
                                    </li>
                                @endif
                            </ul>
                            <div class="tab-content bg-transparent">
                                <div id="note-full-container" class="note-has-grid row align-items-center justify-content-center">
                                    @if (count($notas) > 0)
                                        @foreach ($notas as $nota)
                                            <div class="col-md-6 col-12 single-note-item all-category @if($nota->estatus=="cargado") note-cargados @else note-pendientes @endif" style="">
                                                <div class="card card-body">
                                                    <span class="side-stick"></span>
                                                    <h5 class="note-title mb-0">{{ucwords(strtolower($nota->psnombre))}} <i class="point fa fa-circle ml-1 font-10"></i></h5>
                                                    <p class="note-date font-12 text-muted">{{\Carbon\Carbon::parse($nota->fecha)->format("d F Y")}}</p>
                                                    <div class="note-content">
                                                        <p class="note-inner-content text-muted mb-0 pb-0">Cliente: {{ucwords(strtolower($nota->clientenombre))}}</p>
                                                        <p class="note-inner-content text-muted">Número: {{$nota->codigoCliente}}</p>
                                                        <p class="note-inner-content text-muted">{{$nota->comentario}}</p>
                                                    </div>
                                                    <div class="d-flex align-items-center mt-2">
                                                        <span class="me-1 delete" data-id="{{$nota->notaid}}"><i class="bi bi-trash-fill"></i></span>
                                                        @if(auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos)
                                                            <a class="me-1 download" download="{{$nota->psnombre}}_{{$nota->comprobante}}" href="{{asset("documentos/comprobantes_pagos/convenios/$nota->psnombre/$nota->codigoCliente/$nota->comprobante")}}"><i class="bi bi-download"></i></a>
                                                            <div class="ms-auto">
                                                                <div class="category-selector btn-group">
                                                                    <a class="nav-link dropdown-toggle dropdown-toggle category-dropdown label-group p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                        <div class="category">
                                                                            <div class="category-business"></div>
                                                                            <div class="category-important"></div>
                                                                            <span class="more-options text-dark">
                                                                                <i class="icon-options-vertical"></i>
                                                                            </span>
                                                                        </div>
                                                                    </a>
                                                                    <div class="dropdown-menu dropdown-menu-right category-menu">
                                                                        <a class="note-pendientes badge-group-item badge-business dropdown-item position-relative category-business text-success editar" data-id="{{$nota->notaid}}" data-estatus="cargado" href="javascript:void(0);">
                                                                            <i class="mdi mdi-checkbox-blank-circle-outline me-1"></i>Cargado
                                                                        </a>
                                                                        <a class="note-important badge-group-item badge-important dropdown-item position-relative category-important text-danger editar" data-id="{{$nota->notaid}}" data-estatus="pendiente" href="javascript:void(0);">
                                                                            <i class="mdi mdi-checkbox-blank-circle-outline me-1"></i> Pendiente de carga
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        @if(auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos)
                                            <div class="col-12">
                                                <div class="alert alert-primary d-flex align-items-center" role="alert">
                                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                                                        <use xlink:href="#info-fill" />
                                                    </svg>
                                                    <div>
                                                        No hay ninguna nota
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-12">
                                                <div class="alert alert-primary d-flex align-items-center" role="alert">
                                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                                                        <use xlink:href="#info-fill" />
                                                    </svg>
                                                    <div>
                                                        No tienes ninguna nota
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="addnotesmodal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-fullscreen-lg-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleNota">Añadir nota</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formNota" method="post">
                        @csrf
                        <input type="hidden" name="id" id="idInputNota">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-12 mb-3">
                                <div class="d-flex justify-content-between">
                                    <label for="comprobanteInput" class="form-label">Comprobante de pago</label>
                                    <a id="comprobanteDesc" class="d-none fs-5 text-secondary"><i class="bi bi-download"></i></a>
                                </div>
                                <input type="file" id="comprobanteInput" class="form-control" name="comprobante_pago" required accept="image/*">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <select name="ps_id" class="form-select selectSearch" id="psIdInput">
                                        <option value="" disabled selected>Selecciona...</option>
                                        @if(auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_ps_bronze || auth()->user()->is_ps_diamond)
                                            @foreach($lista_ps as $ps)
                                                <option value="{{ $ps->id }}">{{ $ps->apellido_p }} {{ $ps->apellido_m }} {{ $ps->nombre }}</option>
                                            @endforeach
                                        @else
                                            <option value="{{ $lista_ps->psid }}">{{ $lista_ps->nombrecompleto }}</option>
                                        @endif
                                    </select>
                                    <label for="psIdInput">PS</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <select name="cliente_id" class="form-select selectSearch" id="clienteIdInput">
                                        <option value="" disabled selected>Selecciona...</option>
                                        @foreach($lista_form as $form)
                                        <option value="{{ $form->id }}">{{ $form->apellido_p }}
                                            {{ $form->apellido_m }} {{ $form->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <label for="clienteIdInput">Cliente</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <textarea type="text" class="form-control" placeholder="Ingresa la nota" id="notaInput" name="comentario" title="Ingresa la nota" style="height: 200px; text-transform: none !important;" required></textarea>
                                    <label for="notaInput">Ingresa un comentario</label>
                                </div>
                            </div>
                        </div>
                        <div id="alertMessageNota"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="btnCancelNota" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn principal-button" id="btnSubmitNota">Añadir nota</button>
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
    <script src="{{ asset('js/notas.js') }}"></script>
@endsection