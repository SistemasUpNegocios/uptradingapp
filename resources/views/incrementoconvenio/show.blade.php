@extends('index')

@section('title', 'Incremento cuenta MAM')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css">

    <link rel="stylesheet" href="https://unpkg.com/@jarstone/dselect/dist/css/dselect.css">
@endsection

@section('content')
    <div class="pagetitle">
        <h1>Incremento cuenta MAM</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Vista general</a></li>
                <li class="breadcrumb-item active">Incremento cuenta MAM</li>
            </ol>
        </nav>
    </div>

    <div id="contenedor_filtros" class="contenedor_filtros">
        <div class="card info-card machines-card">
            <div class="card-body pb-0">
                <h5 class="card-title mb-0 text-center">Convenios</h5>
                <div class="col-12 mb-2 px-2">
                    <a class="btn btn-primary mb-2" id="todos">Todos</a>
                    <a class="btn btn-outline-primary mb-2" id="conveniosActivados">Activados</a>
                    <a class="btn btn-outline-primary mb-2" id="conveniosPendientes">Pendientes</a>
                </div>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body mt-3">
                        <div class="alert alert-primary d-flex align-items-center l-bg-primary mt-2" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                                <use xlink:href="#info-fill"></use>
                            </svg>
                            <div id="titulo_filtro">Mostrando todos los incrementos de cuenta MAM</div>
                        </div>

                        @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_ps_diamond)
                            <a class="btn principal-button mb-3 new" data-bs-toggle="modal" data-bs-target="#formModal"> <i class="bi-plus-lg me-1"> </i>Añadir un nuevo incremento</a>
                        @endif
                        <table class="table table-striped table-bordered nowrap text-center" id="convenio">
                            <thead>
                                <tr>
                                    <th data-priority="0" scope="col">Folio</th>
                                    <th data-priority="0" scope="col">Estatus</th>
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
            <path
                d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
        </symbol>
    </svg>

    <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Añadir incremento</h5>
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
                                    <select name="convenio_id" class="form-select selectSearch" id="convenioIdInput">
                                        <option value="" disabled selected>Selecciona...</option>                                       
                                    </select>
                                    <label for="convenioIdInput">Convenio MAM </label>
                                </div>
                            </div>                            
                        </div>
                        <div class="row">
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
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" placeholder="Ingresa la fecha de inicio"
                                        id="fechaInicioInput" name="fecha_inicio" required>
                                    <label for="fechaInicioInput">Fecha de incremento en cuenta MAM</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            @if (auth()->user()->is_root)
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
                                            <option value="Activado" disabled>Activado</option>
                                            <option value="Finiquitado" disabled>Finiquitado</option>
                                            <option value="Refrendado" disabled>Refrendado</option>
                                            <option value="Cancelado" disabled>Cancelado</option>
                                        </select>
                                        <label for="statusInput">Estatus del convenio</label>
                                    </div>
                                </div>
                            @endif

                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="number" step="any" class="form-control"
                                        placeholder="Ingresa la cantidad de inversión en USD" id="montoIncrementoInput" name="monto_incremento"
                                        required>
                                    <label for="montoIncrementoInput">Cantidad a incrementar (USD)</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-12">
                                <div class="form-floating mb-3">
                                    <textarea type="text" class="form-control"
                                        placeholder="Ingresa la cantidad de incremento en letra" id="montoLetraIncrementoInput"
                                        name="montoincremento_letra" style="height: 100px" required></textarea>
                                    <label for="montoLetraIncrementoInput">Cantidad de incremento en letra (USD)</label>
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

                        <div class="col-12">
                            <div class="alert alert-primary d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                                    <use xlink:href="#info-fill" />
                                </svg>
                                <div>
                                    Datos del convenio
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" placeholder="Fecha de inicio" id="fechaInicioConvenioInput" disabled>
                                    <label for="fechaInicioConvenioInput">Fecha de convenio MAM</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="number" step="any" class="form-control" placeholder="Cantidad de inversión" id="montoInput" disabled>
                                    <label for="montoInput">Cantidad de inversión (USD)</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-12">
                                <div class="form-floating mb-3">
                                    <textarea type="text" class="form-control" placeholder="Ingresa la cantidad de inversión en letra" placeholder="Cantidad de inversión en letra" id="montoLetraInput" style="height: 100px" disabled></textarea>
                                    <label for="montoLetraInput">Cantidad de inversión en letra (USD)</label>
                                </div>
                            </div>
                        </div>                        
                    </div>
                    <div id="alertMessage"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="btnCancel" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn principal-button" id="btnSubmit">Añadir Incremento</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <a href="#" id="filtros" title="Filtros de contratos" class="d-flex align-items-center justify-content-center">
        <i class="bi bi-funnel-fill text-white"></i>
    </a>
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
    <script src="{{ asset('js/incrementoconvenio.js') }}"></script>
@endsection