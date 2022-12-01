@extends('index')

@section('title', 'Vista de convenio ' . $convenio[0]->folio)

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css">
@endsection

@section('content')
<div class="pagetitle">
    <h1>Vista de convenio {{ $convenio[0]->folio }}</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Vista general</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/admin/convenio') }}">Gestión de convenios</a></li>
            <li class="breadcrumb-item active">Vista de convenio {{ $convenio[0]->folio }}</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card p-0 rounded">
                <div class="card-body p-0 rounded" style="height: 100vh">
                    <iframe src="/admin/imprimirConvenio?id={{ $convenio[0]->id }}" download="prueba.pdf" class="rounded" title="Ficha" style="width: 100%; height: 100%;">
                    </iframe>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection

@section('preloader')
<div id="loader" class="loader">
    <h1>Generando convenio, espera..</h1>
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
@endsection