@extends('index')

@section('title', 'PS Móvil')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css">
<link rel="stylesheet" href="https://unpkg.com/@jarstone/dselect/dist/css/dselect.css">
@endsection

@section('content')
<div class="pagetitle">
    <h1>Gestión de PS Móvil</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">
                Vista general</a></li>
            <li class="breadcrumb-item active">PS Móvil</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body mt-3">
                    @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos)                    
                        <a class="btn principal-button mb-3 new" data-bs-toggle="modal" data-bs-target="#formModal"> <i class="bi-plus-lg me-1"> </i>Añadir una nueva tableta</a>
                    @endif
                    <table class="table table-striped table-bordered nowrap text-center" style="width: 100%; vertical-align: middle !important" id="psmovil">
                        <thead>
                            <tr>
                                <th data-priority="0" scope="col">PS encargado</th>
                                <th data-priority="0" scope="col">IMEI Tableta</th>
                                <th data-priority="0" scope="col">MAC Wi-Fi tableta</th>
                                <th data-priority="0" scope="col">Número de serie</th>
                                <th data-priority="0" scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody style="vertical-align: middle !important">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Añadir PS Móvil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="psmovilForm" method="post">
                    @csrf
                    <input type="hidden" name="id" id="idInput">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-floating mb-3">
                                <select name="ps_encargado" class="form-select selectSearch" id="psInput">
                                    <option value="" disabled selected>Selecciona...</option>
                                    @foreach($lista_ps as $ps)
                                        <option value="{{ $ps->id }}">
                                            {{ $ps->apellido_p }} {{ $ps->apellido_m }} {{ $ps->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="psInput">PS Encargado</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" minlength="15" maxlength="15" placeholder="Ingresa el imei" id="imeiInput" name="imei" required>
                                <label for="imeiInput">IMEI Tableta</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" minlength="15" maxlength="20" placeholder="Ingresa la mac" id="macInput" name="mac_wifi" required>
                                <label for="macInput">Mac Wi-Fi tableta</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" minlength="1" maxlength="17" placeholder="Ingresa la serie" id="serieInput" name="serie" required>
                                <label for="serieInput">Número de serie</label>
                            </div>
                        </div>
                    </div>
                    <div id="alertMessage"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="btnCancel" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn principal-button" id="btnSubmit">Añadir banco</button>
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
<script src="https://unpkg.com/@jarstone/dselect/dist/js/dselect.js"></script>
<script src="{{ asset('js/psmovil.js') }}"></script>
@endsection