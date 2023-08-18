@extends('index')

@section('title', 'Resumen de pagos a PS')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css">
@endsection

@section('content')
    <div class="pagetitle">
        <h1>Resumen de pagos a PS</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Vista general</a></li>
                <li class="breadcrumb-item active">Resumen de pagos a PS</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body mt-3">
                        <div class="row d-none align-items-center" id="contImprimirResum">
                            <div class="col-md-6 col-12 mb-3">
                                <button class="btn btn-success" id="exportarResumenPs"> 
                                    <i class="bi bi-file-earmark-spreadsheet-fill"></i> Exportar resumen a excel
                                </button>
                            </div>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                            <symbol id="info-fill" fill="#fff" viewBox="0 0 16 16">
                                <path
                                    d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                            </symbol>
                            <symbol id="exclamation-triangle-fill" fill="#fff" viewBox="0 0 16 16">
                                <path
                                    d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                            </symbol>
                        </svg>
                        <div class="alert alert-primary d-flex align-items-center" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
                                aria-label="Info:">
                                <use xlink:href="#info-fill" />
                            </svg>
                            <div>
                                Selecciona una fecha para generar el resumen.
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3 text-center">
                                <label for="" style="margin-right: 20px">Pagar en</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" id="monedaDolaresInput" type="radio" name="moneda" value="dolares" checked>
                                    <label class="form-check-label" for="monedaDolaresInput">dólares</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" id="monedaEurosInput" type="radio" name="moneda" value="euros">
                                    <label class="form-check-label" for="monedaEurosInput">euros</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" id="monedaFrancosInput" type="radio" name="moneda" value="francos">
                                    <label class="form-check-label" for="monedaFrancosInput">francos suizos</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-12">
                                <div class="form-floating mb-2">
                                    <input type="month" class="form-control" id="fechaInput" name="fecha">
                                    <label for="fechaInput">Fecha de pago</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-floating mb-2">
                                    <input type="date" class="form-control" id="dateInput" placeholder="Fecha a imprimir">
                                    <label for="dateInput">Fecha a imprimir</label>
                                </div>
                            </div>
                        </div>

                        <div class="row contDolar">
                            <div class="col-12">
                                <div class="mb-2 form-floating">
                                    <input type="number" class="form-control" id="dolarInput" placeholder="Valor del dolar actual" aria-label="Valor del dolar actual" aria-describedby="botonActualizar">
                                    <label for="dolarInput">Valor del dolar actual</label>
                                </div>
                            </div>
                        </div>

                        <div class="row contEuro">
                            <div class="col-12">
                                <div class="mb-2 form-floating">
                                    <input type="number" class="form-control" id="euroInput" placeholder="Valor del euro actual" aria-label="Valor del euro actual" aria-describedby="botonActualizar">
                                    <label for="euroInput">Valor del euro actual</label>
                                </div>
                            </div>
                        </div>

                        <div class="row contFranco">
                            <div class="col-12">
                                <div class="mb-2 form-floating">
                                    <input type="number" class="form-control" id="francoInput" placeholder="Valor del franco actual" aria-label="Valor del franco suizo actual" aria-describedby="botonActualizar">
                                    <label for="francoInput">Valor del franco suizo actual</label>
                                </div>
                            </div>
                        </div>

                        <div id="tablaResumen">
                            <div class="text-center">
                                <div class="spinner-border text-success" role="status"></div>
                                <p class="text-success">Cargando comisiones<span class="dotting"> </span></p>
                            </div>
                        </div>
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
    <script src="{{ asset('js/reporte-pagosps.js') }}"></script>
@endsection