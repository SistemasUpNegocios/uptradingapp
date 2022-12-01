@extends('index')

@section('title', 'Gestión de pagos a PS de convenios MAM')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css">
@endsection

@section('content')
    <div class="pagetitle">
        <h1 class="titlePage">Gestión de pagos a PS de convenios MAM</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Vista general</a></li>
                <li class="breadcrumb-item active titlePage">Gestión de pagos a PS de convenios MAM</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body mt-3">
                        <a class="btn principal-button mb-3 new" id="btnVolver"> <i class="bi-chevron-left me-1"></i>Ver todos los convenios</a>
                        <table class="text-center mb-3 mt-5 pt-5 table table-bordered nowrap" style="width: 100%; text-transform: uppercase;" id="pagopsconvenio">
                            <thead>
                                <tr>
                                    <th data-priority="0" scope="col">Convenio (folio)</th>
                                    <th data-priority="0" scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="pagoPSBody" style="vertical-align: middle;">
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="pagoPSConvenioForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="idInput">
                        <input type="hidden" name="current_foto" id="currentFotoInput">
                        <div class="row">
                            <div class="col-12">
                                <div class="file-upload mb-3">
                                    <label for="fotoInput">Comprobante de pago</label>
                                    <div class="image-upload-wrap">
                                        <input id="fotoInput" class="file-upload-input" type='file' name="foto" onchange="readURL(this);" accept="image/*" required/>
                                        <div class="drag-text">
                                            <h3>Arrastra una imagen o haz clic aquí</h3>
                                        </div>
                                    </div>
                                    <div class="file-upload-content">
                                        <img class="file-upload-image" src="#" alt="Imagen subida" />
                                        <div class="image-title-wrap">
                                            <button type="button" onclick="removeUpload()" class="remove-image">Eliminar <span class="image-title">comprobante</span></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" title="Campo obligatorio / Solo letras" minlength="3" maxlength="35" class="form-control" placeholder="Ingresa el memo" pattern="[a-zA-Zá-úÁ-Ú ]+" id="memoInput" name="memo" >
                                    <label for="memoInput">Motivo de pago</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="number" minlength="1" maxlength="2" class="form-control" placeholder="Ingresa el mes" id="serieInput" name="serie" required>
                                    <label for="serieInput">Mes</label>
                                </div>
                            </div>
                        </div>
                        <div id="contCalcular" class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" placeholder="Ingresa el monto que hay al momento" id="montoActualInput" name="pago" required>
                                    <label for="montoActualInput">¿Cuál es el saldo de la cuenta MAM?</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="number" value="0.3" class="form-control" placeholder="Ingresa el porcentaje trimestral" id="pTrimestralInput" name="ptrimestral">
                                    <label for="pTrimestralInput">Porcentaje trimestral para pago (%)</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" pattern="[0-9]+" placeholder="Ingresa el monto" id="pagoInput" name="pago">
                                    <label for="pagoInput">Monto de pago (USD)</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" placeholder="Ingresa la fecha de pago" id="fechaPagoInput" name="fecha-pago" required>
                                    <label for="fechaPagoInput">Fecha de pago</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" placeholder="Ingresa la fecha límite de pago" id="fechaLimiteInput" name="fecha-limite" required>
                                    <label for="fechaLimiteInput">Fecha límite de pago</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" placeholder="Ingresa la fecha en la que se realizó el pago" id="fechaPagadoInput" name="fecha_pagado" required>
                                    <label for="fechaPagadoInput">Fecha que se realizó el pago</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <select name="status" class="form-control" id="statusInput" required>
                                        <option value="" disabled selected>Selecciona..</option>
                                        <option value="Pendiente">Pendiente</option>
                                        <option value="Pagado">Pagado</option>
                                        <option value="Cancelado">Cancelado</option>
                                    </select>
                                    <label for="statusInput">Status del pago</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <select name="tipo_pago" class="form-control" id="tipoPagoInput" required>
                                        <option value="" disabled selected>Selecciona..</option>
                                        <option value="Pendiente">Pendiente</option>
                                        <option value="Efectivo">Efectivo</option>
                                        <option value="Transferencia Swissquote a POOL">Transferencia Swissquote a POOL</option>
                                        <option value="Transferencia MX a POOL">Transferencia MX a POOL</option>
                                        <option value="Transferencia HSBC">Transferencia HSBC</option>
                                    </select>
                                    <label for="tipoPagoInput">¿Cómo se realizó el pago?</label>
                                </div>
                            </div>
                        </div>
                        <div id="alertMessage"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="btnCancel" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn principal-button" id="btnSubmit">Editar pago de PS</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="info-fill" fill="#fff" viewBox="0 0 16 16">
            <path
                d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
        </symbol>
    </svg>
    
    <div class="modal fade" id="convenioModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Vista previa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="convenioForm" method="post">
                        @csrf
                        <input type="hidden" name="id" id="idInput">
                        <div id="contPagos"></div>
                        <div class="col-12">
                            <div class="alert alert-primary d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                                    <use xlink:href="#info-fill" />
                                </svg>
                                <div>
                                    Datos generales:
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control"
                                        placeholder="Ingresa el folio del convenio" id="folioInput" name="folio"
                                        value="000-00000-MAM-00-00" required>
                                    <label for="folioInput">Folio del convenio</label>
                                    <div class="row mb-3">
                                        <div class="col-12 d-flex justify-content-between">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="modifySwitch">
                                                <label class="form-check-label" for="modifySwitch">Modificar folio manualmente</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <select name="cliente_id" class="form-control" id="clienteIdInput" required>
                                        <option value="" disabled selected>Selecciona...</option>
                                        @foreach($clientes as $cliente)
                                        <option value="{{ $cliente->id }}">{{ $cliente->apellido_p }}
                                            {{ $cliente->apellido_m }} {{ $cliente->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <label for="clienteIdInput">Cliente</label>
                                </div>
                            </div>
    
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <select name="ps_id" minlength="3" maxlength="120" pattern="[a-zA-Zá-úÁ-Ú ]+"
                                        class="form-control" id="psIdInput" required>
                                        <option value="" disabled selected>Selecciona..</option>
                                        @foreach($lista_ps as $ps)
                                        <option value="{{ $ps->id }}">{{ $ps->nombre }} {{ $ps->apellido_p }}
                                            {{ $ps->apellido_m }}</option>
                                        @endforeach
                                    </select>
                                    <label for="psIdInput">PS</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" placeholder="Ingresa la fecha de inicio" id="fechaInicioInput" name="fecha_inicio" required>
                                    <label for="fechaInicioInput">Fecha de inicio</label>
                                </div>
                            </div>
    
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" placeholder="Ingresa la fecha de fin" id="fechaFinInput" name="fecha_fin" required>
                                    <label for="fechaFinInput">Fecha de fin</label>
                                </div>
                            </div>
                        </div>
    
                        <div class="col-12">
                            <div class="alert alert-primary d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                                    <use xlink:href="#info-fill" />
                                </svg>
                                <div>
                                    Datos del convenio:
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-12">
                                <div class="form-floating mb-3">
                                    <input type="number" step="any" pattern="[0-9.]+" class="form-control" placeholder="Ingresa la comisión por apertura" id="cAperturaInput" value="3" name="capertura" required>
                                    <label for="cAperturaInput">Comisión por apertura del PS (%)</label>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-floating mb-3">
                                    <input type="number" step="any" pattern="[0-9.]+" class="form-control" placeholder="Ingresa la comisión mensual" id="cMensualInput" value="0.5" name="cmensual" required>
                                    <label for="cMensualInput">Comisión mensual del PS (%)</label>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-floating mb-3">
                                    <input type="number" step="any" pattern="[0-9.]+" class="form-control"  placeholder="Ingresa la comisión trimestral" id="cTrimestralInput" value="0.3" name="ctrimestral" required>
                                    <label for="cTrimestralInput">Comisión trimestral del PS (%)</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="number" step="any" class="form-control" placeholder="Ingresa la cantidad de inversión en USD" id="montoInput" name="monto" required>
                                    <label for="montoInput">Cantidad de inversión (USD)</label>
                                </div>
                            </div>
    
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <textarea type="text" class="form-control" placeholder="Ingresa la cantidad de inversión en letra" id="montoLetraInput" name="monto_letra" style="height: 100px" required></textarea>
                                    <label for="montoLetraInput">Cantidad de inversión en letra (USD)</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos)                       
                                <div class="col-md-6 col-12">
                                    <div class="form-floating mb-3">
                                        <select name="status" class="form-control" id="statusInput" required>
                                            <option value="" disabled>Selecciona...</option>
                                            <option value="Pendiente de activación" selected>Pendiente de activación</option>
                                            <option value="Activado">Activado</option>
                                            <option value="Finiquitado">Finiquitado</option>
                                            <option value="Refrendado">Refrendado</option>
                                            <option value="Cancelado">Cancelado</option>
                                        </select>
                                        <label for="statusInput">Status del convenio</label>
                                    </div>
                                </div>
                            @else
                                <div class="col-md-6 col-12">
                                    <div class="form-floating mb-3">
                                        <select name="status" class="form-control" id="statusInput" required>
                                            <option value="" disabled>Selecciona...</option>
                                            <option value="Pendiente de activación" selected>Pendiente de activación</option>
                                        </select>
                                        <label for="statusInput">Status del convenio</label>
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <select name="banco_id" minlength="3" maxlength="120" pattern="[a-zA-Zá-úÁ-Ú ]+"
                                        class="form-control" id="bancoIdInput" required>
                                        <option value="" disabled>Selecciona..</option>
                                        @foreach($bancos as $banco)
                                        @if ($banco->nombre == "SWISSQUOTE")
                                        <option value="{{ $banco->id }}" selected>{{ $banco->nombre }}</option>
                                        @else
                                        <option value="{{ $banco->id }}">{{ $banco->nombre }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                    <label for="bancoIdInput">Banco</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" step="any" class="form-control" placeholder="Ingresa el número de cuenta" id="numeroCuentaInput" value="CH" name="numerocuenta" required>
                                    <label for="numeroCuentaInput">Número de cuenta</label>
                                </div>
                            </div>
                        </div>
                        <div id="alertMessage"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="btnCancel" data-bs-dismiss="modal">Cerrar vista previa</button>
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
    <script src="{{ asset('js/pagopsconvenio.js') }}"></script>
@endsection