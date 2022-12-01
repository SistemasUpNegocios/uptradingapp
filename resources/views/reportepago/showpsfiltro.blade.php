@extends('index')

@section('title', 'Reporte filtrado (pagos a PS)')

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
        <h1>Reporte filtrado (pagos a PS)</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Vista general</a></li>
                <li class="breadcrumb-item active">Reporte filtrado (pagos a PS)</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="alert alert-primary d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                        <use xlink:href="#info-fill" />
                    </svg>
                    <div>
                        Selecciona las fechas en las que deseas generar un reporte:
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-12 d-flex">
                                <div class="col-md-6">
                                    <a href="" id="btnHoy" class="btn principal-button mb-3">Hoy</a>
                                    <a href="" id="btnSiete" class="btn principal-button mb-3">Últimos 7 días</a>
                                    <a href="" id="btnQuince" class="btn principal-button mb-3">Últimos 15 días</a>
                                    <a href="" id="btnMes" class="btn principal-button mb-3">Último mes</a>
                                </div>
                                <div class="col-md-6 d-flex justify-content-end">
                                    <a href="" id="btnMenosDesde" class="btn principal-button me-1 mb-3">-1 día (D)</a>
                                    <a href="" id="btnMasDesde" class="btn principal-button me-1 mb-3">+1 día (D)</a>
                                    <a href="" id="btnMenosHasta" class="btn principal-button me-1 mb-3">-1 día (H)</a>
                                    <a href="" id="btnMasHasta" class="btn principal-button me-1 mb-3">+1 día (H)</a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5 col-12">
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" placeholder="Ingresa la fecha desde"
                                        id="fechaDesdeInput" required>
                                    <label for="fechaDesdeInput">Fecha desde</label>
                                </div>
                            </div>
                            <div class="col-md-5 col-12">
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" placeholder="Ingresa la fecha hasta"
                                        id="fechaHastaInput" required>
                                    <label for="fechaHastaInput">Fecha hasta</label>
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <button type="submit" class="btn principal-button" id="btnGenerar">Generar reporte</button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div id="contFrame" style="height: 100vh"></div>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ asset('js/reportepagops.js') }}"></script>
@endsection