@if (count($notas) > 0)
    @foreach ($notas as $nota)
        <div class="col-md-6 col-12 single-note-item all-category @if($nota->estatus=="cargado")note-cargados @else note-pendientes @endif" style="">
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