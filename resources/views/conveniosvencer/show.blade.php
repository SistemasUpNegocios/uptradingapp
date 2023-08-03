@extends('index')

@section('title', 'Gestión de convenios a vencer')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css">
    <style>
        table.dataTable th, table.dataTable td {
            font-size: 14px;
        }
    </style>
@endsection

@section('content')
    <div class="pagetitle">
        <h1>Gestión de convenios a vencer</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Vista general</a></li>
                <li class="breadcrumb-item active">Gestión de convenios a vencer</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body mt-3">
                        <div class="col-12">
                            <div class="alert alert-primary d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                                    <use xlink:href="#info-fill" />
                                </svg>
                                <div>
                                    Si el botón de <b>"NOTA"</b> está en gris es que existe una nota, de lo contrario, está vacía.
                                </div>
                            </div>
                        </div>
                        <table class="table table-striped table-bordered nowrap text-center" id="convenioVencer">
                            <thead style="vertical-align: middle">
                                <tr>
                                    <th data-priority="0" scope="col">Folio</th>
                                    <th data-priority="0" scope="col">Cliente</th>
                                    <th data-priority="0" scope="col">Fecha de inicio</th>
                                    <th data-priority="0" scope="col">Fecha de vencimiento</th>
                                    <th data-priority="0" scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody style="vertical-align: middle;">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="info-fill" fill="#fff" viewBox="0 0 16 16">
            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
        </symbol>
    </svg>

    <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Añadir convenio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="convenioForm" method="post">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id" id="idInput">
                        <div id="contPagos"></div>
                        <div class="col-12">
                            <div class="alert alert-primary d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                                    <use xlink:href="#info-fill" />
                                </svg>
                                <div>
                                    Ingresa los datos generales:
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-12">
                                <label class="form-check-label me-2">¿Quién firma?</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="firma" id="gerenteInput" value="MARIA EUGENIA RINCON ACEVAL" checked>
                                    <label class="form-check-label" for="gerenteInput">Gerente general</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="firma" id="representanteInput" value="HILARIO HAMILTON HERRERA COSSAIN">
                                    <label class="form-check-label" for="representanteInput">Representante legal</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" placeholder="Ingresa el folio del convenio"
                                        id="folioInput" name="folio" value="000-00000-MAM-00-00" required>
                                    <label for="folioInput">Folio del convenio</label>
                                    <div class="row mb-3">
                                        <div class="col-12 d-flex justify-content-between">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="modifySwitch">
                                                <label class="form-check-label" for="modifySwitch">Modificar folio
                                                    manualmente</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <select name="cliente_id" class="form-select selectSearch" id="clienteIdInput">
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
                                        class="form-select selectSearch" id="psIdInput">
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
                                    <input type="date" class="form-control" placeholder="Ingresa la fecha de inicio"
                                        id="fechaInicioInput" name="fecha_inicio" required>
                                    <label for="fechaInicioInput">Fecha de inicio</label>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" placeholder="Ingresa la fecha de fin"
                                        id="fechaFinInput" name="fecha_fin" required>
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
                                    Ingresa los datos del convenio:
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="number" step="any" pattern="[0-9.]+" class="form-control"
                                        placeholder="Ingresa la comisión por apertura" id="cAperturaInput" value="3"
                                        name="capertura" required>
                                    <label for="cAperturaInput">Comisión por apertura del PS (%)</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="number" step="any" pattern="[0-9.]+" class="form-control"
                                        placeholder="Ingresa la comisión mensual" id="cMensualInput" value="0.5"
                                        name="cmensual" required>
                                    <label for="cMensualInput">Comisión mensual del PS (%)</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="number" step="any" pattern="[0-9.]+" class="form-control"
                                        placeholder="Ingresa la comisión trimestral" id="cTrimestralInput" value="0.3"
                                        name="ctrimestral" required>
                                    <label for="cTrimestralInput">Comisión trimestral del PS (%)</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="number" step="any" class="form-control"
                                        placeholder="Ingresa la cantidad de inversión en USD" id="montoInput" name="monto"
                                        required>
                                    <label for="montoInput">Cantidad de inversión (USD)</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-12">
                                <div class="form-floating mb-3">
                                    <textarea type="text" class="form-control"
                                        placeholder="Ingresa la cantidad de inversión en letra" id="montoLetraInput"
                                        name="monto_letra" style="height: 100px" required></textarea>
                                    <label for="montoLetraInput">Cantidad de inversión en letra (USD)</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
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
                        <div class="row d-none" id="contMemoCan">
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <textarea class="form-control" placeholder="Ingresa el memo de cancelacion"
                                        id="memoCanInput" name="memo_status" style="height: 100px"></textarea>
                                    <label for="memoCanInput">Memo de cancelacion</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" step="any" class="form-control"
                                        placeholder="Ingresa el número de cuenta" id="numeroCuentaInput" value="CH"
                                        name="numerocuenta" required>
                                    <label for="numeroCuentaInput">Número de cuenta</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" step="any" class="form-control" style="text-transform: none !important;"
                                        placeholder="Ingresa el loggin" id="logginInput"
                                        name="loggin">
                                    <label for="logginInput">Loggin</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-floating mb-3">
                                    <select class="form-control" id="beneficiariosInput">
                                        <option value="1" selected>1 beneficiario</option>
                                        <option value="2">2 beneficiarios</option>
                                        <option value="3">3 beneficiarios</option>
                                    </select>
                                    <label for="invitadoInput">Número de beneficiarios</label>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="contBeneficiarios"></div>
                    </div>
                    <div id="alertMessage"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="btnCancel" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn principal-button" id="btnSubmit">Añadir convenio</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="formModalNota" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-fullscreen-lg-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleNota">Añadir convenio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="alert alert-primary d-flex align-items-center mx-2" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                        <use xlink:href="#info-fill" />
                    </svg>
                    <div>
                        SI EL CONVENIO SE VA A <b>RENOVAR</b>, NO AÑADAS UNA NOTA. EL SISTEMA LO RENOVARÁ AUTOMÁTICAMENTE.
                    </div>
                </div>

                <div class="modal-body">
                    <form id="convenioFormNota" method="post">
                        @csrf
                        <input type="hidden" name="id" id="idInputNota">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <textarea type="text" class="form-control" placeholder="Ingresa la nota" id="notaInput" name="nota_convenio" title="Ingresa la nota" style="height: 200px; text-transform: none !important;" ></textarea>
                                    <label for="notaInput">Nota</label>
                                </div>
                            </div>
                        </div>
                        <div id="alertMessageNota"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="btnCancelNota" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn principal-button" id="btnSubmitNota">Añadir convenio</button>
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
    <script src="{{ asset('js/conveniovencer.js') }}"></script>
@endsection