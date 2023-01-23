@extends('index')

@section('title', 'Intención de inversión')

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
        <h1>Intención de inversión</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Vista general</a></li>
                <li class="breadcrumb-item active">Intención de inversión</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="alert alert-primary d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
                        aria-label="Info:">
                        <use xlink:href="#info-fill" />
                    </svg>
                    <div>
                        Llena todos los campos para generar una intención de inversión:
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body mt-3">
                        <form action="{{ url('/admin/reporteIntencion') }}" method="post">
                            @csrf
                            <div id="contForm">
                                @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos || auth()->user()->is_ps_diamond)
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="clienteSwitch">
                                                <label class="form-check-label" for="clienteSwitch">¿La intención de inversión es para un cliente existente?</label>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="row" id="contCliente">
                                    <div class="col-md-6 col-12">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control"
                                                placeholder="Ingresa el nombre completo" id="nombreInput"
                                                name="nombre" required style="text-transform: none;">
                                            <label for="nombreInput">Nombre completo del inversor</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-floating mb-3">
                                            <input type="email" class="form-control"
                                                placeholder="Ingresa el correo electrónico" id="emailInput"
                                                name="email" required style="text-transform: none;">
                                            <label for="emailInput">Correo electrónico</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-floating mb-3">
                                            <input type="number" step="any" class="form-control"
                                                placeholder="Ingresa la cantidad de inversión" id="telefonoInput"
                                                name="telefono" required>
                                            <label for="telefonoInput">Número de teléfono</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5 col-12">
                                        <div class="form-floating mb-3">
                                            <input type="number" step="any" class="form-control"
                                                placeholder="Ingresa la cantidad de inversión" id="inversionInput"
                                                name="inversion" required>
                                            <label for="inversionInput">Cantidad de inversión (MXN)</label>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-12">
                                        <div class="form-floating mb-3">
                                            <input type="number" step="any" class="form-control"
                                                placeholder="Ingresa la cantidad de inversión en USD" id="inversionUsInput"
                                                name="inversion_us" required>
                                            <label for="inversionUsInput">Cantidad de inversión (USD)</label>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-12">
                                        <div class="form-floating mb-3">
                                            <input type="number" step="any" class="form-control"
                                                placeholder="Ingresa el tipo de cambio" id="tipoCambioInput"
                                                name="tipo_cambio" required>
                                            <label for="tipoCambioInput">MXN - USD</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-12">
                                        <div class="form-floating mb-3">
                                            <input type="date" class="form-control" placeholder="Ingresa la fecha de inicio"
                                                id="fechaInicioInput" name="fecha_inicio" required>
                                            <label for="fechaInicioInput">Fecha de inicio</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-floating mb-3">
                                            <input type="date" class="form-control"
                                                placeholder="Ingresa la fecha de renovación" id="fechaRenInput"
                                                name="fecha_renovacion" required>
                                            <label for="fechaRenInput">Fecha de renovación</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-floating mb-3">
                                            <input type="date" class="form-control" placeholder="Ingresa la fecha de pago"
                                                id="fechaPagInput" name="fecha_pago" required>
                                            <label for="fechaPagInput">Fecha de pago</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="dividirSwitch">
                                            <label class="form-check-label" for="dividirSwitch">¿La inversión se dividirá
                                                en dos contratos?</label>
                                        </div>
                                    </div>
                                </div>
                                <div id="contOpciones">
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12 d-flex">
                                        <button type="submit" class="btn principal-button me-3"><i class="bi bi-file-earmark-pdf me-1"></i>Generar reporte en PDF</button>
                                    </div>
                                </div>
                                <div id="contTabla">
                                </div>
                                <div id="contTabla2">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
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
    <script src="{{ asset('js/intencion.js') }}"></script>
@endsection