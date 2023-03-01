@extends('index')

@section('title', 'Flujo de dinero')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css">

    <style>
        table.dataTable th, table.dataTable td {
            font-size: 12px;
        }
    </style>
@endsection

@section('content')
    <div class="pagetitle">
        <h1>Flujo de dinero</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Vista general</a></li>
                <li class="breadcrumb-item active">Flujo de dinero</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body mt-3">
                        <div class="row align-items-center justify-content-between">
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
                                   Si borras la fecha, se mostrará el flujo de dinero total.
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <a class="btn principal-button ms-1" id="imprimirReporte"> 
                                    <i class="bi bi-printer-fill me-1"></i> Imprimir reporte
                                </a>
                            </div>
                            <div class="col-md-12 col-12 mt-2">
                                <div class="form-floating">
                                    <input type="month" class="form-control" id="fechaInput" name="fecha">
                                    <label for="fechaInput">Fecha de pago</label>
                                </div>                                
                            </div>
                        </div>
                        <div id="contTotal" class="mt-4"></div>
                        <div class="mt-4" style="overflow-x: auto;">
                            <table class="table table-striped table-bordered nowrap text-center" style="width: 100%" id="flujoDinero">
                                <thead>                               
                                    <tr>
                                        <th data-priority="0" scope="col">Contrato</th>
                                        <th data-priority="0" scope="col">Fecha</th>
                                        <th data-priority="0" scope="col">Cliente</th>
                                        <th data-priority="0" scope="col">PS</th>
                        
                                        <th data-priority="0" scope="col">Swissquote a POOL</th>
                                        <th data-priority="0" scope="col">Rendimientos</th>
                                        <th data-priority="0" scope="col">Renovación</th>
                                        <th data-priority="0" scope="col">Comisiones</th>
                                        <th data-priority="0" scope="col">MX a POOL</th>
                                        <th data-priority="0" scope="col">Efectivo</th>
                                        <th data-priority="0" scope="col">CI BANK</th>
                                        <th data-priority="0" scope="col">HSBC</th>
                                    </tr>
                                </thead>
                                <tbody id="flujoDineroBody" style="vertical-align: middle;">
                                </tbody>
                            </table>
                        </div>
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
    <script src="{{ asset('js/flujodinero.js') }}"></script>
@endsection