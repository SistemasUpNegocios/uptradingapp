@extends('index')

@section('title', 'Gestión de tipos de contrato')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css">
@endsection

@section('content')
    <div class="pagetitle">
        <h1 class="titlePage">Gestión de tipos de contrato</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Vista general</a></li>
                <li class="breadcrumb-item active titlePage">Gestión de tipos de contrato</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body mt-3">
                        @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos)
                        <a id="newTipo" class="btn principal-button mb-3 new" data-bs-toggle="modal" data-bs-target="#formModal"> <i
                                class="bi-plus-lg me-1"> </i>Añadir un nuevo tipo de contrato</a>
                        @endif
                        @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos)
                        <a id="newClausula" class="btn principal-button mb-3 new" data-bs-toggle="modal" data-bs-target="#formModalClausula"> <i
                            class="bi-plus-lg me-1"> </i>Añadir una nueva cláusula</a>
                        <a class="btn principal-button mb-3 new" id="btnVolver"> <i class="bi-chevron-left me-1"></i>Volver</a>
                        @endif
                        <table class="table table-striped table-bordered nowrap" style="width: 100%" id="tipoContrato">
                            <thead>
                                <tr>
                                    <th data-priority="0" scope="col">Tipo</th>
                                    <th data-priority="0" scope="col">Modelo</th>
                                    <th data-priority="0" scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="psBody" style="vertical-align: middle;">
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
                    <h5 class="modal-title" id="modalTitle">Añadir tipo de contrato</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="tipoContratoForm" method="post">
                        @csrf
                        <input type="hidden" name="id" id="idInput">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" minlength="3" maxlength="50" placeholder="Ingresa el nombre del tipo de contrato" id="tipoInput" name="tipo" required style="text-transform: none !important;">
                                    <label for="floatingInput">Nombre de tipo de contrato</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <textarea type="text" class="form-control" minlength="3" maxlength="70" placeholder="Ingresa la redacción del tipo de contrato" id="redaccionInput" name="redaccion" style="height: 200px; text-transform: none !important;" required></textarea>
                                    <label for="floatingInput">Redacción del tipo de contrato</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-floating mb-3">
                                    <input type="number" step="any" class="form-control" placeholder="Ingresa la comisión por apertura" id="cAperturaInput" name="capertura" required>
                                    <label for="floatingInput">Comisión por apertura (%)</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-floating mb-3">
                                    <input type="number" step="any" class="form-control" placeholder="Ingresa la comisión mensual" id="cMensualInput" name="cmensual" required>
                                    <label for="floatingInput">Comisión mensual (%)</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-floating mb-3">
                                    <input type="number" step="any" class="form-control" placeholder="Ingresa el rendimiento mensual" id="rendimientoInput" name="rendimiento" required>
                                    <label for="floatingInput">Rendimiento mensual (%)</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-floating mb-3">
                                    <select name="modelo_id" class="form-control" id="modeloIdInput" required>
                                        <option value="" disabled selected>Selecciona..</option>
                                        @foreach($lista_modelos as $modelo)
                                        <option value="{{ $modelo->id }}">{{ $modelo->modelo }}</option>
                                        @endforeach
                                    </select>
                                    <label for="tipoIdInput">Versión de modelo</label>
                                </div>                            
                            </div>
                        </div>
                        <div class="row">                        
                            <div class="col-6">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" name="tabla" type="checkbox" role="switch" id="tablaInput">
                                    <label class="form-check-label" for="tablaInput">¿Contiene tabla?</label>
                                </div>
                            </div>
                        </div>
                        <div id="alertMessage"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="btnCancel" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn principal-button" id="btnSubmit">Añadir tipo de contrato</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="formModalClausula" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Añadir cláusula</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="clausulaForm" method="post">
                        @csrf
                        <input type="hidden" name="id" id="idInput">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <textarea type="text" class="form-control" placeholder="Ingresa la redacción de la cláusula" id="redaccionInput" name="redaccion" style="height: 100px; text-transform: none !important;" required></textarea>
                                    <label for="redaccionInput">Redacción de la cláusula</label>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="tipoid" id="TipoIdInput">
                        <div id="alertMessage"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="btnCancel" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn principal-button" id="btnSubmit">Añadir cláusula</button>
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
    <script src="{{ asset('js/tipocontrato.js') }}"></script>
@endsection