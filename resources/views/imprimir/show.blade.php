@extends('index')

@section('title', 'Vista de contrato ' . $contratos->contrato)

@section('css')
    
@endsection

@section('content')
<div class="pagetitle">
    <h1>Vista de contrato {{ $contratos->contrato }}</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Vista general</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/admin/contrato') }}">Gestión de contratos</a></li>
            <li class="breadcrumb-item active">Vista de contrato {{ $contratos->contrato }}</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card p-0 rounded">
                <div class="card-body p-0 rounded" style="height: 100vh">
                    <iframe id="imprimirPdf" src="/admin/imprimir?id={{ $contratos->id }}
                        @if (auth()->user()->is_cliente || auth()->user()->is_ps_asistente || auth()->user()->is_cliente_ps_asistente)
                            #toolbar=0
                        @endif" 
                    download="prueba.pdf" class="rounded" title="Ficha" style="width: 100%; height: 100%;">
                    </iframe>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection

@section('preloader')
<div id="loader" class="loader">
    <h1>Generando contrato, espera..</h1>
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
    
@endsection