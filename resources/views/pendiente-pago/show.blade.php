@extends('index')

@section('title', 'Gestión de pendientes de pago')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="https://unpkg.com/@jarstone/dselect/dist/css/dselect.css">
    <style>
        .vaciado th {
            font-size: 14px;
            padding: 6px;
        }
        .vaciado td {
            font-size: 13px;
            padding: 5px;
        }
    </style>
@endsection

@section('content')
    <div class="pagetitle">
        <h1>Gestión de pendientes de pago</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Vista general</a></li>
                <li class="breadcrumb-item active">Gestión de pendientes de pago</li>
            </ol>
        </nav>
    </div>

    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="info-fill" fill="#fff" viewBox="0 0 16 16">
            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
        </symbol>
    </svg>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body mt-3">
                        <div class="alert alert-primary d-flex align-items-center l-bg-primary mb-2" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                                <use xlink:href="#info-fill"></use>
                            </svg>
                            <div>
                               Elige un cliente para ver solo su información.
                            </div>
                        </div>

                        <div class="form-floating mb-3">
                            <select class="form-select selectSearch" id="clienteIdInput" >
                                <option value="all" selected>TODOS</option>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}">{{ $cliente->apellido_p }} {{$cliente->nombre }}</option>
                                @endforeach
                            </select>
                            <label for="clienteIdInput">Cliente</label>
                        </div>

                        <div class="row align-items-center" id="data">
                            <div class="col-12 mb-3">
                                <button id="generarVaciado" data-id="all" class="btn btn-success"><i class="bi bi-file-earmark-spreadsheet-fill"></i> Generar excel</button>
                            </div>
                            @foreach ($contratos as $contrato)
                                    @php
                                        $nombre = $contrato->nombre;
                                        $cont = substr($contrato->contrato, 0, 9);
                                        $fecha = \Carbon\Carbon::parse($contrato->fecha)->format('d/m/Y');
                                        $tipo = strtoupper(substr($contrato->tipo, 12));
                                        $capital = "$".number_format($contrato->inversion_us, 2);

                                        $pagos = App\Models\PagoCliente::select('pago', 'fecha_pago', 'status')->where('contrato_id', $contrato->id)->groupBy('status')->orderBy('status', 'ASC')->first();
                                        $rendimiento = "$".number_format($pagos->pago, 2);
                                        $pendiente = strtoupper(\Carbon\Carbon::parse($pagos->fecha_pago)->formatLocalized('%B'));
                                    @endphp
                                    @if($pagos->status != 'Pagado')
                                        <div class="col-md-6 col-12">
                                            <table class="table table-dark table-bordered text-center vaciado" style="width: 100%;">
                                                <thead>
                                                    <tr><th colspan="2">{{$nombre}}</th></tr>
                                                </thead>
                                                <tbody class="table-secondary">
                                                    <tr>
                                                        <td>Contrato</td>
                                                        <td>{{$cont}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Fecha de inicio</td>
                                                        <td>{{$fecha}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tipo</td>
                                                        <td>{{$tipo}}</td>
                                                    </tr>
                                                    
                                                    @if($tipo === "MENSUAL")
                                                        <tr>
                                                            <td>Capital</td>
                                                            <td>{{$capital}} DLLS</td>
                                                        </tr>
                                                        <tr>
                                                            <td>RENDIMIENTO</td>
                                                            <td>{{$rendimiento}} DLLS</td>
                                                        </tr>
                                                        <tr>
                                                            <td>PENDIENTE</td>
                                                            <td>{{$pendiente}} A LA FECHA</td>
                                                        </tr>
                                                    @else
                                                        <tr>
                                                            <td>Capital & Rendimiento</td>
                                                            <td>{{$rendimiento}} DLLS</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                            @endforeach
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
    <script src="https://unpkg.com/@jarstone/dselect/dist/js/dselect.js"></script>
    <script src="{{ asset('js/pendiente-pago.js') }}"></script>
@endsection