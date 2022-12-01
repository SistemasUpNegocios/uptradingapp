@extends('index')

@section('title', 'Reporte mensual (pagos a PS)')

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/@jarstone/dselect/dist/css/dselect.css">
@endsection

@section('content')
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="info-fill" fill="#fff" viewBox="0 0 16 16">
            <path
                d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
        </symbol>
    </svg>

    <div class="pagetitle">
        <h1>Reporte mensual (pagos a PS)</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Vista general</a></li>
                <li class="breadcrumb-item active">Reporte mensual (pagos a PS)</li>
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
                        Selecciona el mes del que deseas generar un reporte:
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body p-3">
                        @php
                            $primer_fecha = \Carbon\Carbon::parse($primer_fecha)->startOfMonth();
                            $primer_fecha = $primer_fecha->toDateString();

                            $ultima_fecha = \Carbon\Carbon::parse($ultima_fecha)->startOfMonth();
                            $ultima_fecha = $ultima_fecha->toDateString();
                        @endphp
                        
                        <div class="row">
                            <div class="col-10">
                                <div class="form-floating mb-3">
                                    <select class="form-select selectSearch" id="mesInput" required>
                                        <option value="" disabled selected>Selecciona..</option>
                                        @while ($primer_fecha != $ultima_fecha)
                                        @php
                                            $primer_fecha = \Carbon\Carbon::parse($primer_fecha);
                                            $primer_fecha = $primer_fecha->addMonths(1);
                                            $primer_fecha = $primer_fecha->toDateString();

                                            $fecha_texto = \Carbon\Carbon::parse(strtotime($primer_fecha))->formatLocalized('%B de %Y');
                                        @endphp
                                        <option value="{{ $primer_fecha }}">{{ $fecha_texto }}</option>                                        
                                        @endwhile
                                    </select>
                                    <label for="mesInput">Selecciona el mes</label>
                                </div>
                            </div>
                            <div class="col-2">
                                <button type="submit" class="btn principal-button" id="btnGenerar">Generar reporte mensual</button>
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
    <script src="https://unpkg.com/@jarstone/dselect/dist/js/dselect.js"></script>
    <script src="{{ asset('js/reportemespagops.js') }}"></script>
@endsection