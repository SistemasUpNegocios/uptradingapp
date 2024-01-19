@extends('index')

@section('title', 'Historial de pagos')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css">
@endsection

@section('content')
    <div class="pagetitle">
        <h1>Historial de pagos</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Vista general</a></li>
                <li class="breadcrumb-item active">Historial de pagos</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body mt-3">
                        <table class="table table-striped table-bordered nowrap text-center" id="pagos">
                            <thead style="vertical-align: middle">
                                <tr>
                                    <th data-priority="0" scope="col">Contrato</th>
                                    <th data-priority="0" scope="col">Monto</th>
                                    <th data-priority="0" scope="col">Pago</th>
                                    <th data-priority="0" scope="col">Dólar</th>
                                    <th data-priority="0" scope="col">Memo</th>
                                    <th data-priority="0" scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="pagosBody" style="vertical-align: middle;">
                            </tbody>
                        </table>
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
    <script src="{{ asset('js/pagos.js') }}"></script>
@endsection