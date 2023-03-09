@extends('index')

@section('title', 'Gestión de porcentajes de contratos')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css">
@endsection

@section('content')
<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol id="info-fill" fill="#fff" viewBox="0 0 16 16">
        <path
            d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
    </symbol>
</svg>

<div class="pagetitle">
    <h1>Gestión de porcentajes de contratos</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Vista general</a></li>
            <li class="breadcrumb-item active">Gestión de porcentajes de contratos</li>
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
                    Aquí podrás modificar el porcentaje <b>(rendimiento del contrato)</b> para los contratos no activados en casos especiales de atender. Si el contrato a modificar no se encuentra en la siguiente tabla, reporta desactivarlo a la persona encargada.
                </div>
            </div>
        </div>

        <div class="col-lg-12">

            <div class="card">
                <div class="card-body mt-3">
                    <table class="table table-striped table-bordered nowrap text-center" id="porcentaje">
                        <thead>
                            <tr>
                                <th data-priority="0" scope="col">Contrato</th>
                                <th data-priority="0" scope="col">Rendimiento</th>
                                <th data-priority="0" scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody style="vertical-align: middle;">
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</section>

<div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-fullscreen-lg-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Añadir contrato</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="contratoForm" method="post">
                    @csrf
                    <input type="hidden" name="id" id="idInput">
                    <div id="contPagos"></div>
                    <div class="col-12">
                        <div class="alert alert-primary d-flex align-items-center" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                                <use xlink:href="#info-fill" />
                            </svg>
                            <div>
                                Porcentajes del contrato:
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" title="Campo obligatorio / Solo números"
                                    placeholder="Ingresa el rendimiento" id="porcentajeInput" name="porcentaje" step="0.1"
                                    required>
                                <label for="porcentajeInput">Rendimiento del contrato (%)</label>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" title="Campo obligatorio / Solo números"
                                    placeholder="Ingresa la comisión por apertura" id="cAperturaInput" name="capertura" step="0.1"
                                    required>
                                <label for="cAperturaInput">Comisión por apertura PS (%)</label>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" title="Campo obligatorio / Solo números"
                                    placeholder="Ingresa la comisión mensual" id="cMensualInput" name="cmensual" step="0.1"
                                    required>
                                <label for="cMensualInput">Comisión mensual PS (%)</label>
                            </div>
                        </div>                        
                    </div>
                    <div class="col-12">
                        <div class="alert alert-primary d-flex align-items-center" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                                <use xlink:href="#info-fill" />
                            </svg>
                            <div>
                                Datos generales:
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-12" id="clienteIdCont">
                            <div class="form-floating mb-3">
                                <select name="cliente_id" class="form-control" id="clienteIdInput" required>
                                    <option value="" disabled selected>Selecciona...</option>
                                    @foreach($lista_clientes as $cliente)
                                    <option value="{{ $cliente->id }}">{{ $cliente->apellido_p }}
                                        {{ $cliente->apellido_m }} {{ $cliente->nombre }}</option>
                                    @endforeach
                                </select>
                                <label for="clienteIdInput">Cliente</label>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-3">
                                <input type="text" title="Campo obligatorio / Solo letras" minlength="5" maxlength="12"
                                    class="form-control" placeholder="Ingresa el contrato" id="contratoInput"
                                    name="contrato" value="00000-000-0" required>
                                <label for="contratoInput">Contrato</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">                        
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" placeholder="Ingresa la fecha de inicio"
                                    id="fechaInicioInput" name="fechainicio" required>
                                <label for="fechaInicioInput">Fecha de inicio</label>
                            </div>
                        </div>                        
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" placeholder="Ingresa la fecha de renovación"
                                    id="fechaRenInput" name="fecha_renovacion" required>
                                <label for="fechaRenInput">Fecha de renovación</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control"
                                    placeholder="Ingresa la fecha de termino de contrato" id="fechaPagInput"
                                    name="fecha_pago" required>
                                <label for="fechaPagInput">Fecha termino de contrato</label>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control"
                                    placeholder="Ingresa la fecha limite de liquidación" id="fechaLimiteInput"
                                    name="fecha_limite" required>
                                <label for="fechaLimiteInput">Fecha limite de liquidación</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-3">
                                <select name="periodo" class="form-control" id="periodoInput" required disabled>
                                    <option value="" disabled>Selecciona...</option>
                                    <option value="1" disabled>1 mes</option>
                                    <option value="2" disabled>2 meses</option>
                                    <option value="3">3 meses</option>
                                    <option value="4" disabled>4 meses</option>
                                    <option value="5" disabled>5 meses</option>
                                    <option value="6">6 meses</option>
                                    <option value="7" disabled>7 meses</option>
                                    <option value="8" disabled>8 meses</option>
                                    <option value="9" disabled>9 meses</option>
                                    <option value="10" disabled>10 meses</option>
                                    <option value="11" disabled>11 meses</option>
                                    <option value="12" selected>12 meses</option>
                                </select>
                                <label for="periodoInput">Periodo del contrato</label>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-3">
                                <select name="ps_id" minlength="3" maxlength="120" pattern="[a-zA-Zá-úÁ-Ú ]+"
                                    class="form-control" id="psIdInput" required>
                                    <option value="" disabled selected>Selecciona..</option>
                                    @foreach($lista_ps as $ps)
                                    <option value="{{ $ps->id }}">{{ $ps->nombre }} {{ $ps->apellido_p }}
                                        {{ $ps->apellido_m }}</option>
                                    @endforeach
                                </select>
                                <label for="psIdInput">PS</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="alert alert-primary d-flex align-items-center" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                                <use xlink:href="#info-fill" />
                            </svg>
                            <div>
                                Datos del contrato:
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-3">
                                <input type="text" step="any" class="form-control"
                                    placeholder="Ingresa el folio del contrato" id="folioInput" name="folio" value="0"
                                    required>
                                <label for="folioInput">Ingresa el folio del contrato</label>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-3">
                                <select name="tipo_id" class="form-control" id="tipoIdInput" required>
                                    <option value="" disabled selected>Selecciona..</option>
                                    @foreach($lista_tipos as $tipo)
                                    <option id="optionInput" value="{{ $tipo->id }}"
                                        data-capertura="{{ $tipo->capertura }}" data-cmensual="{{ $tipo->cmensual }}"
                                        data-rendimiento="{{ $tipo->rendimiento }}" data-tipo="{{ $tipo->tipo }}">{{
                                        $tipo->tipo }}</option>
                                    @endforeach
                                </select>
                                <label for="tipoIdInput">Tipo de contrato</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-3">
                                <input type="number" step="any" pattern="[0-9.]+" class="form-control"
                                    placeholder="Ingresa el porcentaje" id="porcentajeRenInput" name="porcentaje2" required
                                    readonly>
                                <label for="porcentajeRenInput">Porcentaje del rendimiento de contrato (%)</label>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-3">
                                <input type="number" step="any" class="form-control"
                                    placeholder="Ingresa el tipo de cambio" id="tipoCambioInput" name="tipo_cambio"
                                    required>
                                <label for="tipoCambioInput">Tipo de cambio MXN - USD</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-3">
                                <input type="number" step="any" class="form-control"
                                    placeholder="Ingresa la cantidad de inversión" id="inversionInput" name="inversion"
                                    required>
                                <label for="inversionInput">Cantidad de inversión (MXN)</label>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-3">
                                <input type="number" step="any" class="form-control"
                                    placeholder="Ingresa la cantidad de inversión en USD" id="inversionUsInput"
                                    name="inversion_us" required>
                                <label for="inversionUsInput">Cantidad de inversión (USD)</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-3">
                                <textarea type="text" class="form-control"
                                    placeholder="Ingresa la cantidad de inversión en letra" id="inversionLetInput"
                                    name="inversion_letra" style="height: 100px" required></textarea>
                                <label for="inversionLetInput">Cantidad de inversión en letra (MXN)</label>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-3">
                                <textarea type="text" class="form-control"
                                    placeholder="Ingresa la cantidad de inversión en letra" id="inversionLetUsInput"
                                    name="inversion_letra_us" style="height: 100px" required></textarea>
                                <label for="inversionLetUsInput">Cantidad de inversión en letra (USD)</label>
                            </div>
                        </div>
                    </div>
                    <div class="row cont-tabla"></div>
                    <div id="alertMessage"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="btnCancel" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn principal-button" id="btnSubmit">Añadir contrato</button>
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
<script src="{{ asset('js/porcentaje.js') }}"></script>
@endsection