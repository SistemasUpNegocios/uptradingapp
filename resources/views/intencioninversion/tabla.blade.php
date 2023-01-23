@extends('index')

@section('title', 'Gestión de intención de inversión')

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
        <h1>Gestión de intención de inversión</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Vista general</a></li>
                <li class="breadcrumb-item active">Gestión de intención de inversión</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

            <div class="card">
                <div class="card-body mt-3">
                    <table class="table table-striped table-bordered nowrap" style="width: 100%" id="intencion">
                        <thead>
                            <tr>
                                <th data-priority="0" scope="col">Nombre completo</th>
                                <th data-priority="0" scope="col">Teléfono</th>
                                <th data-priority="0" scope="col">Email</th>
                                <th data-priority="0" scope="col">Inversión USD</th>
                                <th data-priority="0" scope="col">Fecha de inicio</th>
                                <th data-priority="0" scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="intencionBody">
                        </tbody>
                    </table>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-fullscreen-lg-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Añadir intención</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="intencionForm" method="post">
                        @csrf
                        <input type="hidden" name="id" id="idInput">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" placeholder="Ingresa el nombre" id="nombreInput" name="nombre" required>
                                    <label for="nombreInput">Nombre</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" placeholder="Ingresa el telefono" id="telefonoInput" name="telefono" required>
                                    <label for="telefonoInput">Teléfono</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" placeholder="Ingresa el correo electrónico" id="emailInput" name="email" style="text-transform: none !important;" required>
                                    <label for="emailInput">Email</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" placeholder="Ingresa el tipo de cambio"
                                        id="tipoCambioInput" name="tipo_cambio" required>
                                    <label for="tipoCambioInput">Tipo de cambio</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="number" step="any" class="form-control" placeholder="Ingresa la cantidad de inversión" id="inversionInput" name="inversion" required>
                                    <label for="inversionInput">Cantidad de inversión (MXN)</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="number" step="any" class="form-control" placeholder="Ingresa la cantidad de inversión en USD" id="inversionUsInput" name="inversion_us" required>
                                    <label for="inversionUsInput">Cantidad de inversión (USD)</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-12">
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control"
                                        placeholder="Ingresa la fecha de inicio" id="fechaInicioInput"
                                        name="fecha_inicio" required>
                                    <label for="fechaInicioInput">Fecha de inicio</label>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control"
                                        placeholder="Ingresa la fecha de pago" id="fechaPagoInput"
                                        name="fecha_pago" required>
                                    <label for="fechaPagoInput">Fecha de pago</label>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control"
                                        placeholder="Ingresa la fecha de renovación" id="fechaRenovacionInput"
                                        name="fecha_renovacion" required>
                                    <label for="fechaRenovacionInput">Fecha de renovación</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" step="any" class="form-control" placeholder="Ingresa el tipo 1 de contrato" id="tipo1Input" name="tipo_1" required>
                                    <label for="tipo1Input">Primer contrato</label>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-floating mb-3">
                                    <input type="number" step="any" class="form-control" placeholder="Ingresa el porcentaje de contrato tipo 1" id="porcentajeTipo1Input" name="porcentaje_tipo_1" required>
                                    <label for="porcentajeTipo1Input">Porcentaje del primer contrato (%)</label>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-floating mb-3">
                                    <input type="number" step="any" class="form-control" placeholder="Ingresa el porcentaje de inversión del primer tipo de contrato" id="porcentajeInversion1Input" name="porcentaje_inversion_1" required>
                                    <label for="porcentajeInversion1Input">Inversión del primer contrato (%)</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" step="any" class="form-control" placeholder="Ingresa el tipo 2 de contrato" id="tipo2Input" name="tipo_2" required>
                                    <label for="tipo2Input">Segundo contrato</label>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-floating mb-3">
                                    <input type="number" step="any" class="form-control" placeholder="Ingresa el porcentaje de contrato tipo 2" id="porcentajeTipo2Input" name="porcentaje_tipo_2" required>
                                    <label for="porcentajeTipo2Input">Porcentaje del segundo contrato (%)</label>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-floating mb-3">
                                    <input type="number" step="any" class="form-control" placeholder="Ingresa el porcentaje de inversión del segundo tipo de contrato" id="porcentajeInversion2Input" name="porcentaje_inversion_2" required>
                                    <label for="porcentajeInversion2Input">Inversión del segundo contrato (%)</label>
                                </div>
                            </div>
                        </div>

                        <div id="alertMessage"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="btnCancel" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn principal-button" id="btnSubmit">Añadir intencion</button>
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
    <script src="{{ asset('js/intencion.js') }}"></script>
@endsection