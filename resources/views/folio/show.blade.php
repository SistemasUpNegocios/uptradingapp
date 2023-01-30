@extends('index')

@section('title', 'Gestión de folios')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css">
@endsection

@section('content')
<div class="pagetitle">
    <h1>Gestión de folios</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Vista general</a></li>
            <li class="breadcrumb-item active">Gestión de folios</li>
        </ol>
    </nav>
</div>

<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol id="info-fill" fill="#fff" viewBox="0 0 16 16">
        <path
            d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
    </symbol>
</svg>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body mt-3">
                    <div class="mb-5">
                        <div class="alert alert-primary d-flex align-items-center l-bg-primary mt-2" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                                <use xlink:href="#info-fill"></use>
                            </svg>
                            <div>
                                Folios cancelados
                            </div>
                        </div>

                        <table class="table table-striped table-bordered nowrap text-center" style="width: 100%" id="folioCancelado">
                            <thead>
                                <tr>
                                    <th data-priority="0" scope="col">Número de folio</th>
                                    <th data-priority="0" scope="col">Contrato</th>
                                    <th data-priority="0" scope="col">Estatus del folio</th>
                                    <th data-priority="0" scope="col">Fecha del folio</th>
                                    <th data-priority="0" scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <div class="alert alert-primary d-flex align-items-center l-bg-primary mt-2" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                                <use xlink:href="#info-fill"></use>
                            </svg>
                            <div>
                                Folios en uso
                            </div>
                        </div>

                        <table class="table table-striped table-bordered nowrap text-center" style="width: 100%" id="folio">
                            <thead>
                                <tr>
                                    <th data-priority="0" scope="col">Número de folio</th>
                                    <th data-priority="0" scope="col">Contrato</th>
                                    <th data-priority="0" scope="col">Estatus del folio</th>
                                    <th data-priority="0" scope="col">Fecha del folio</th>
                                    <th data-priority="0" scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Añadir folio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="folioForm" method="post">
                    @csrf
                    <input type="hidden" name="id" id="idInput">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" placeholder="Ingresa número de folio" id="folioInput" name="folio" required>
                                <label for="folioInput">Número de folio</label>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-3">
                                <select name="contrato_id" class="form-control" id="contratoIdInput" required>
                                    <option value="" disabled selected>Selecciona..</option>
                                    @foreach($lista_contratos as $contrato)
                                        <option value="{{ $contrato->id }}">{{$contrato->contrato }}</option>
                                    @endforeach
                                </select>
                                <label for="contratoIdInput">Contrato</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-3">
                                <select name="estatus" class="form-control" id="estatusInput" required>
                                    <option value="" disabled selected>Selecciona..</option>
                                    <option value="En uso">En uso</option>
                                    <option value="Cancelado">Cancelado</option>
                                </select>
                                <label for="estatusInput">Estatus del folio</label>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" placeholder="Ingresa la fecha"
                                    id="fechaInput" name="fecha" required>
                                <label for="fechaInput">Fecha de creación</label>
                            </div>
                        </div>
                    </div>
                    <div id="alertMessage"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="btnCancel" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn principal-button" id="btnSubmit">Añadir folio</button>
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
<script src="{{ asset('js/folio.js') }}"></script>
@endsection