@extends('index')

@section('title', 'Gestión de contratos a vencer')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css">
    <style>
        table.dataTable th, table.dataTable td {
            font-size: 14px;
        }
    </style>
@endsection

@section('content')
    <div class="pagetitle">
        <h1>Gestión de contratos a vencer</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Vista general</a></li>
                <li class="breadcrumb-item active">Gestión de contratos a vencer</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body mt-3">
                        <div class="col-12">
                            <div class="alert alert-primary d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                                    <use xlink:href="#info-fill" />
                                </svg>
                                <div>
                                    Si el botón de <b>"NOTA"</b> está en gris es que existe una nota, de lo contrario, está vacía.
                                </div>
                            </div>
                        </div>
                        <table class="table table-striped table-bordered nowrap text-center" id="contratoVencer">
                            <thead style="vertical-align: middle">
                                <tr>
                                    <th data-priority="0" scope="col">Contrato</th>
                                    <th data-priority="0" scope="col">Cliente</th>
                                    <th data-priority="0" scope="col">Fecha de inicio</th>
                                    <th data-priority="0" scope="col">Fecha de vencimiento</th>
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

    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="info-fill" fill="#fff" viewBox="0 0 16 16">
            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
        </symbol>
    </svg>

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
                                    Ingresa los datos generales:
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" title="Campo obligatorio / Solo letras"
                                        minlength="3" maxlength="75" pattern="[a-zA-Zá-úÁ-Ú ]+"
                                        placeholder="Ingresa el operador" id="operadorInput" name="operador"
                                        value="MARIA EUGENIA RINCON ACEVAL" required>
                                    <label for="operadorInput">Operador</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="number" minlength="5" maxlength="30" class="form-control"
                                        placeholder="Ingresa la INE" id="operadorINEInput" name="operador_ine" required
                                        value="0228061546388">
                                    <label for="floatingInput">INE del Operador</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12" id="clienteIdCont">
                                <div class="form-floating mb-3">
                                    <select name="cliente_id" class="form-select selectSearch" id="clienteIdInput">
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
                                    <input type="text" title="Campo obligatorio / Solo letras" minlength="3" maxlength="30"
                                        class="form-control" placeholder="Ingresa el lugar de firma" id="lugarFirmaInput"
                                        name="lugar_firma" value="Durango, Dgo. México" required>
                                    <label for="lugarFirmaInput">Lugar de firma</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" placeholder="Ingresa la fecha de inicio"
                                        id="fechaInicioInput" name="fechainicio" required>
                                    <label for="fechaInicioInput">Fecha de inicio</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <select name="periodo" class="form-control" id="periodoInput" required disabled>
                                        <option value="" disabled>Selecciona...</option>
                                        <option value="3" disabled>3 meses</option>
                                        <option value="6" disabled>6 meses</option>
                                        <option value="9" disabled>9 meses</option>
                                        <option value="12" selected>12 meses</option>
                                    </select>
                                    <label for="periodoInput">Periodo del contrato</label>
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
                            <div class="col-md-12 col-12">
                                <div class="form-floating mb-3">
                                    <select name="ps_id" minlength="3" maxlength="120" pattern="[a-zA-Zá-úÁ-Ú ]+"
                                        class="form-select selectSearch" id="psIdInput">
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
                                    Ingresa los datos del contrato:
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" step="any" class="form-control" placeholder="Ingresa el folio del contrato" id="folioInput" name="folio" required>
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
                                    <input type="number" step="any" pattern="[0-9.]+" class="form-control" placeholder="Ingresa el porcentaje" id="porcentajeInput" name="porcentaje" required readonly>
                                    <label for="porcentajeInput">Porcentaje del rendimiento de contrato (%)</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="number" step="any" class="form-control" placeholder="Ingresa el tipo de cambio" id="tipoCambioInput" name="tipo_cambio" required>
                                    <label for="tipoCambioInput">Tipo de cambio MXN - USD</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="number" step="any" class="form-control" placeholder="Ingresa la cantidad de inversión" id="inversionInput" name="inversion" required>
                                    <label for="inversionInput">Cantidad de inversión (MXN)</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="number" step="any" class="form-control" placeholder="Ingresa la cantidad de inversión en USD" id="inversionUsInput" name="inversion_us" required>
                                    <label for="inversionUsInput">Cantidad de inversión (USD)</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <textarea type="text" class="form-control" placeholder="Ingresa la cantidad de inversión en letra" id="inversionLetInput" name="inversion_letra" style="height: 100px" required></textarea>
                                    <label for="inversionLetInput">Cantidad de inversión en letra (MXN)</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <textarea type="text" class="form-control" placeholder="Ingresa la cantidad de inversión en letra" id="inversionLetUsInput" name="inversion_letra_us" style="height: 100px" required></textarea>
                                    <label for="inversionLetUsInput">Cantidad de inversión en letra (USD)</label>
                                </div>
                            </div>
                        </div>
                        @if (auth()->user()->is_root)
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <select name="status" class="form-control" id="statusInput" required>
                                            <option value="" disabled>Selecciona...</option>
                                            <option value="Pendiente de activación" selected>Pendiente de activación</option>
                                            <option value="Activado">Activado</option>
                                            <option value="Finiquitado">Finiquitado</option>
                                            <option value="Refrendado">Refrendado</option>
                                            <option value="Cancelado">Cancelado</option>
                                        </select>
                                        <label for="statusInput">Status del contrato</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-none" id="contMemoCan">
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <textarea class="form-control" placeholder="Ingresa el memo de cancelacion"
                                            id="memoCanInput" name="memo_status" style="height: 100px"></textarea>
                                        <label for="memoCanInput">Memo de cancelacion</label>
                                    </div>
                                </div>
                            </div>
                        @elseif(auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos)
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <select name="status" class="form-control" id="statusInput" required>
                                            <option value="" disabled>Selecciona...</option>
                                            <option value="Pendiente de activación">Pendiente de activación</option>
                                            <option value="Activado" disabled>Activado</option>
                                            <option value="Finiquitado">Finiquitado</option>
                                            <option value="Refrendado">Refrendado</option>
                                            <option value="Cancelado">Cancelado</option>
                                        </select>
                                        <label for="statusInput">Status del contrato</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-none" id="contMemoCan">
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <textarea class="form-control" placeholder="Ingresa el memo de cancelacion"
                                            id="memoCanInput" name="memo_status" style="height: 100px"></textarea>
                                        <label for="memoCanInput">Memo de cancelacion</label>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <select name="status" class="form-control" id="statusInput" required>
                                            <option value="" disabled>Selecciona...</option>
                                            <option value="Pendiente de activación" selected>Pendiente de activación</option>
                                            <option value="Activado" disabled>Activado</option>
                                            <option value="Finiquitado" disabled>Finiquitado</option>
                                            <option value="Refrendado" disabled>Refrendado</option>
                                            <option value="Cancelado" disabled>Cancelado</option>
                                        </select>
                                        <label for="statusInput">Status del contrato</label>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="row cont-tabla"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-floating mb-3">
                                    <select class="form-control" id="beneficiariosInput">
                                        <option value="1" selected>1 beneficiario</option>
                                        <option value="2">2 beneficiarios</option>
                                        <option value="3">3 beneficiarios</option>
                                    </select>
                                    <label for="invitadoInput">Número de beneficiarios</label>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="contBeneficiarios"></div>
                        <div class="col-12">
                            <div class="alert alert-primary d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                                    <use xlink:href="#info-fill" />
                                </svg>
                                <div>
                                    Información del pago
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-3">
                                <div class="mb-1">
                                    <label class="fs-5"><strong>Tipo de pago</strong></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="efectivoInput" name="tipo_pago[]" value="efectivo">
                                    <label class="form-check-label" for="efectivoInput">Efectivo</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="transferenciaSwissInput" name="tipo_pago[]" value="transferencia_swiss_pool">
                                    <label class="form-check-label" for="transferenciaSwissInput">Transferencia de Swissquote a POOL</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="transferenciaMXInput" name="tipo_pago[]" value="transferencia_mx_pool">
                                    <label class="form-check-label" for="transferenciaMXInput">Transferencia directa MX a POOL</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="ciBankInput" name="tipo_pago[]" value="ci_bank">
                                    <label class="form-check-label" for="ciBankInput">CI BANK</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="hsbcInput" name="tipo_pago[]" value="HSBC">
                                    <label class="form-check-label" for="hsbcInput">HSBC</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="renovacionInput" name="tipo_pago[]" value="renovacion">
                                    <label class="form-check-label" for="renovacionInput">Renovación</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="rendimientosInput" name="tipo_pago[]" value="rendimientos">
                                    <label class="form-check-label" for="rendimientosInput">Rendimientos</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="comisionesInput" name="tipo_pago[]" value="comisiones">
                                    <label class="form-check-label" for="comisionesInput">Comisiones</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12" id="montoEfectivoCont">
                                <div class="form-floating mb-3">
                                    <input type="number" step="any" class="form-control" placeholder="Ingresa el monto en efectivo" id="montoEfectivoInput" name="monto_pago[]">
                                    <label for="montoEfectivoInput">Monto en efectivo</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12" id="montoTransSwissPOOLCont">
                                <div class="form-floating mb-3">
                                    <input type="number" step="any" class="form-control" placeholder="Ingresa el monto de transferencia Swiss a POOL" id="montoTransSwissPOOLInput" name="monto_pago[]">
                                    <label for="montoTransSwissPOOLInput">Monto de transferencia Swiss a POOL</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12" id="montoTransMXPOOLCont">
                                <div class="form-floating mb-3">
                                    <input type="number" step="any" class="form-control" placeholder="Ingresa el monto de transferencia MX a POOL" id="montoTransMXPOOLInput" name="monto_pago[]">
                                    <label for="montoTransMXPOOLInput">Monto de transferencia MX a POOL</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12" id="montoBankCont">
                                <div class="form-floating mb-3">
                                    <input type="number" step="any" class="form-control" placeholder="Ingresa el monto en CI BANK" id="montoBankInput" name="monto_pago[]">
                                    <label for="montoBankInput">Monto en CI BANK</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12" id="montoHSBCCont">
                                <div class="form-floating mb-3">
                                    <input type="number" step="any" class="form-control" placeholder="Ingresa el monto en HSBC" id="montoHSBCInput" name="monto_pago[]">
                                    <label for="montoHSBCInput">Monto en HSBC</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12" id="montoRenovacionCont">
                                <div class="form-floating mb-3">
                                    <input type="number" step="any" class="form-control" placeholder="Ingresa el monto en renovación" id="montoRenovacionInput" name="monto_pago[]">
                                    <label for="montoRenovacionInput">Monto en renovación</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12" id="montoRendimientosCont">
                                <div class="form-floating mb-3">
                                    <input type="number" step="any" class="form-control" placeholder="Ingresa el monto en rendimientos" id="montoRendimientosInput" name="monto_pago[]">
                                    <label for="montoRendimientosInput">Monto en rendimientos</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12" id="montoComisionesCont">
                                <div class="form-floating mb-3">
                                    <input type="number" step="any" class="form-control" placeholder="Ingresa el monto en comisiones" id="montoComisionesInput" name="monto_pago[]">
                                    <label for="montoComisionesInput">Monto en comisiones</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-3">
                                <div class="d-flex justify-content-between">
                                    <label for="comprobantePagoInput" class="form-label">Comprobante(s) de pago</label>
                                    <a id="comprobantePagoDesc" class="d-none fs-5 text-secondary"><i class="bi bi-download"></i></a>
                                </div>
                                <input type="file" id="comprobantePagoInput" class="form-control" name="comprobante_pago[]" multiple>
                            </div>
                        </div>
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

    <div class="modal fade" id="formModalNota" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-fullscreen-lg-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleNota">Añadir contrato</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="alert alert-primary d-flex align-items-center mx-2" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                        <use xlink:href="#info-fill" />
                    </svg>
                    <div>
                        SI EL CONTRATO SE VA A <b>RENOVAR</b>, NO AÑADAS UNA NOTA. EL SISTEMA LO RENOVARÁ AUTOMÁTICAMENTE.
                    </div>
                </div>

                <div class="modal-body">
                    <form id="contratoFormNota" method="post">
                        @csrf
                        <input type="hidden" name="id" id="idInputNota">
                        <div class="row mb-2">
                            <div class="col-12">
                                <label class="form-check-label me-2">¿Para quién es?</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="ticket_persona" id="maruInput" value="234" checked>
                                    <label class="form-check-label" for="maruInput">Maru</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="ticket_persona" id="marlenInput" value="246">
                                    <label class="form-check-label" for="marlenInput">Marlen</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <textarea type="text" class="form-control" placeholder="Ingresa la nota" id="notaInput" name="nota_contrato" title="Ingresa la nota" style="height: 200px; text-transform: none !important;" ></textarea>
                                    <label for="notaInput">Nota</label>
                                </div>
                            </div>
                        </div>
                        <div id="alertMessageNota"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="btnCancelNota" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn principal-button" id="btnSubmitNota">Añadir contrato</button>
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
    <script src="{{ asset('js/contratovencer.js') }}"></script>
@endsection