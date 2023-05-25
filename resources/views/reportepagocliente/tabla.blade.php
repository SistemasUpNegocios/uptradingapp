@if (sizeof($resumenes_contrato) > 0)
    <div class="mt-4" style="overflow-x: auto;">
        <table class="table table-striped table-bordered nowrap text-center" style="width: 100%; vertical-align: middle" id="resumenPagoCliente">
            <thead style="vertical-align: middle">
                <tr>
                    <th style="font-size: 12.5px !important; width: 30px !important;" data-priority="0" scope="col">Contrato</th>
                    <th style="font-size: 12.5px !important; width: 30px !important;" data-priority="0" scope="col">Cliente</th>
                    <th style="font-size: 12.5px !important; width: 30px !important;" data-priority="0" scope="col">Rendimiento (MXN)</th>
                    <th style="font-size: 12.5px !important; width: 30px !important;" data-priority="0" scope="col">Rendimiento (USD)</th>
                    <th style="font-size: 12.5px !important; width: 30px !important;" data-priority="0" scope="col">Pago</th>
                    <th style="font-size: 12.5px !important; width: 30px !important;" data-priority="0" scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody id="resumenBody" style="vertical-align: middle">
                @foreach ($resumenes_contrato as $resumen)
                    @php
                        if (strlen($resumen->contrato) == 11){
                            $contrato = substr($resumen->contrato, 0, -2);
                        }else{
                            $contrato = substr($resumen->contrato, 0, -3);
                        }
                        $cliente = $resumen->clientenombre;
                        $rendimiento = number_format($resumen->pago * $dolar, 2);
                        $pago = str_pad($resumen->serie_pago, 2, "0", STR_PAD_LEFT).'/12';
                        $fecha = $resumen->fecha;
                        $pago_dolares = number_format($resumen->pago, 2);
                        $pagos_bd = App\Models\Pago::where('id_contrato', $resumen->contratoid)->where("memo", "Pago a cliente ($pago)")->orderBy("id", "DESC")->first();
                    @endphp
                        <tr>
                            <td style="font-size: 12.5px">
                                {{ $contrato }}
                            </td>
                            <td style="font-size: 12.5px">{{ $cliente }}</td>
                            <td style="font-size: 12.5px">${{ $rendimiento }}</td>
                            <td style="font-size: 12.5px">${{ number_format($resumen->pago, 2) }}</td>
                            @if($resumen->tipo_id == 1)
                                <td style="font-size: 12.5px">{{ $pago }}</td>
                            @else
                                <td style="font-size: 12.5px">COMPUESTO</td>
                            @endif

                            @if ($resumen->tipo_id == 1 && $reporte == "mensual")
                                <td class="d-flex align-items-center justify-content-center">
                                    @if($pagos_bd)
                                        <button title="Información de pago" class="btn btn-secondary nota ms-1" style="font-size: 13px; padding: 7px" data-pagoid="{{$resumen->pagoid}}" data-contratoid="{{$resumen->contratoid}}" data-pesos="{{ $rendimiento }}" data-dolares="{{$resumen->pago}}" data-pago="{{$pago}}" data-id="{{$pagos_bd->id}}" data-monto="{{$pagos_bd->monto}}" data-tipopago="{{$pagos_bd->tipo_pago}}"> <i class="bi bi-journal-text"></i></button>
                                    @else
                                        <button title="Información de pago" class="btn btn-dark nota ms-1" style="font-size: 13px; padding: 7px" data-pagoid="{{$resumen->pagoid}}" data-contratoid="{{$resumen->contratoid}}" data-pesos="{{ $rendimiento }}" data-dolares="{{$resumen->pago}}" data-pago="{{$pago}}"> <i class="bi bi-journal-text"></i></button>
                                    @endif
                                    <button class="btn btn-warning ms-1 reporte" style="font-size: 13px; padding: 7px" data-pago="{{$pago}}" data-cliente="{{$cliente}}" data-rendimiento="{{$rendimiento}}" data-rendimientoini="{{ $resumen->pago }}" data-fecha="{{$fecha}}" data-contrato="{{$contrato}}" data-contratoid="{{ $resumen->contratoid }}" data-tipo="{{$resumen->tipo_id}}" data-reporte="mensual" title="Imprimir pago" id="imprimirReporte"><i class="bi bi-clipboard-data"></i></button>
                                    <button class="btn btn-success ms-1 editar_pago" style="font-size: 13px; padding: 7px" data-bs-toggle="modal" data-bs-target="#formModal"  data-pago="{{$pago}}" data-cliente="{{$cliente}}" data-rendimiento="{{$rendimiento}}" data-rendimientoini="{{ $resumen->pago }}" data-fecha="{{$fecha}}" data-contrato="{{$contrato}}" data-contratoid="{{ $resumen->contratoid }}" data-reporte="mensual" data-tipo="{{$resumen->tipo_id}}" title="Editar pago" id="editarInput"><i class="bi bi-pencil"></i></button>
                                    <button class="btn btn-primary abrirWhats whats_tabla ms-1" data-pago="{{$pago}}" data-cliente="{{$cliente}}" data-rendimiento="{{$rendimiento}}" data-rendimientoini="{{ $resumen->pago }}" data-fecha="{{ \Carbon\Carbon::parse($fecha)->formatLocalized('%d de %B de %Y') }}" data-contrato="{{$contrato}}" data-clientenumero="{{ $resumen->clientenumero }}" data-tipo="{{$resumen->tipo_id}}" title="Mandar whats para pago por transferencia"><i class="bi bi-whatsapp"></i></button>
                                    <button class="btn btn-primary abrirTrans whatsTrans_tabla ms-1" data-pago="{{$pago}}" data-cliente="{{$cliente}}" data-rendimiento="{{$pago_dolares}}" data-rendimientoini="{{ $resumen->pago }}" data-fecha="{{ \Carbon\Carbon::parse($fecha)->formatLocalized('%d de %B de %Y') }}" data-contrato="{{$contrato}}" data-clientenumero="{{ $resumen->clientenumero }}" data-tipo="{{$resumen->tipo_id}}" title="Mandar whats para pago por transferencia Swissquote"><i class="bi bi-whatsapp"></i></button>
                                    
                                    <input id="pagadoStatus" class="status form-check-input fs-6 m-0 p-0 ms-1" type="checkbox" data-id="{{ $resumen->pagoid }}" data-contratoid="{{ $resumen->contratoid }}" data-pago="{{$pago}}" @if ($resumen->status=="Pagado" ) {{"checked"}} @endif>
                                    <label class="form-check-label ms-1" style="font-size: 15px" for="pagadoStatus">¿Pago realizado?</label>
                                </td>
                            @elseif ($resumen->tipo_id == 1 && $reporte == "liquidacion")
                                <td class="d-flex align-items-center justify-content-center">
                                    @if($pagos_bd)
                                        <button title="Información de pago" class="btn btn-secondary nota ms-1" style="font-size: 13px; padding: 7px" data-pagoid="{{$resumen->pagoid}}" data-contratoid="{{$resumen->contratoid}}" data-pesos="{{ $rendimiento }}" data-dolares="{{$resumen->pago}}" data-pago="{{$pago}}" data-id="{{$pagos_bd->id}}" data-monto="{{$pagos_bd->monto}}" data-tipopago="{{$pagos_bd->tipo_pago}}"> <i class="bi bi-journal-text"></i></button>
                                    @else
                                        <button title="Información de pago" class="btn btn-dark nota ms-1" style="font-size: 13px; padding: 7px" data-pagoid="{{$resumen->pagoid}}" data-contratoid="{{$resumen->contratoid}}" data-pesos="{{ $rendimiento }}" data-dolares="{{$resumen->pago}}" data-pago="{{$pago}}"> <i class="bi bi-journal-text"></i></button>
                                    @endif
                                    <button class="btn btn-warning ms-1 reporte" style="font-size: 13px; padding: 7px" data-pago="{{$pago}}" data-cliente="{{$cliente}}" data-rendimiento="{{$rendimiento}}" data-fecha="{{$fecha}}" data-contrato="{{$contrato}}" data-contratoid="{{ $resumen->contratoid }}" data-tipo="{{$resumen->tipo_id}}" data-inversionus="{{$resumen->inversion_us}}" data-reporte="liquidacion" title="Imprimir pago" id="imprimirReporte"><i class="bi bi-clipboard-data"></i></button>
                                    <button class="btn btn-success ms-1 editar_pago" style="font-size: 13px; padding: 7px" data-bs-toggle="modal" data-bs-target="#formModal"  data-pago="{{$pago}}" data-cliente="{{$cliente}}" data-rendimiento="{{$rendimiento}}" data-rendimientoini="{{ $resumen->pago }}" data-fecha="{{$fecha}}" data-contrato="{{$contrato}}" data-contratoid="{{ $resumen->contratoid }}" data-tipo="{{$resumen->tipo_id}}" data-inversionus="{{$resumen->inversion_us}}" data-reporte="liquidacion" title="Editar pago" id="editarInput"><i class="bi bi-pencil"></i></button>
                                    <button class="btn btn-primary abrirWhats whats_tabla ms-1" data-pago="{{$pago}}" data-cliente="{{$cliente}}" data-rendimiento="{{$rendimiento}}" data-rendimientoini="{{ $resumen->pago }}" data-fecha="{{ \Carbon\Carbon::parse($fecha)->formatLocalized('%d de %B de %Y') }}" data-contrato="{{$contrato}}" data-clientenumero="{{ $resumen->clientenumero }}" data-tipo="{{$resumen->tipo_id}}" title="Mandar whats para pago por transferencia"><i class="bi bi-whatsapp"></i></button>
                                    <button class="btn btn-primary abrirTrans whatsTrans_tabla ms-1" data-pago="{{$pago}}" data-cliente="{{$cliente}}" data-rendimiento="{{$pago_dolares}}" data-rendimientoini="{{ $resumen->pago }}" data-fecha="{{ \Carbon\Carbon::parse($fecha)->formatLocalized('%d de %B de %Y') }}" data-contrato="{{$contrato}}" data-clientenumero="{{ $resumen->clientenumero }}" data-tipo="{{$resumen->tipo_id}}" title="Mandar whats para pago por transferencia Swissquote"><i class="bi bi-whatsapp"></i></button>
                                    
                                    <input id="pagadoStatus" class="status form-check-input fs-6 m-0 p-0 ms-1" type="checkbox" data-id="{{ $resumen->pagoid }}" data-contratoid="{{ $resumen->contratoid }}" data-pago="{{$pago}}" @if ($resumen->status=="Pagado" ) {{"checked"}} @endif>
                                    <label class="form-check-label ms-1" style="font-size: 15px" for="pagadoStatus">¿Pago realizado?</label>
                                </td>
                            @elseif($resumen->tipo_id == 2)
                                <td class="d-flex align-items-center justify-content-center">
                                    @if($pagos_bd)
                                        <button title="Información de pago" class="btn btn-secondary nota ms-1" style="font-size: 13px; padding: 7px" data-pagoid="{{$resumen->pagoid}}" data-contratoid="{{$resumen->contratoid}}" data-pesos="{{ $rendimiento }}" data-dolares="{{$resumen->pago}}" data-pago="{{$pago}}" data-id="{{$pagos_bd->id}}" data-monto="{{$pagos_bd->monto}}" data-tipopago="{{$pagos_bd->tipo_pago}}"> <i class="bi bi-journal-text"></i></button>
                                    @else
                                        <button title="Información de pago" class="btn btn-dark nota ms-1" style="font-size: 13px; padding: 7px" data-pagoid="{{$resumen->pagoid}}" data-contratoid="{{$resumen->contratoid}}" data-pesos="{{ $rendimiento }}" data-dolares="{{$resumen->pago}}" data-pago="{{$pago}}"> <i class="bi bi-journal-text"></i></button>
                                    @endif
                                    <button class="btn btn-warning ms-1 reporte" style="font-size: 13px; padding: 7px" data-pago="{{$pago}}" data-cliente="{{$cliente}}" data-rendimiento="{{$rendimiento}}" data-rendimientoini="{{ $resumen->pago }}" data-fecha="{{$fecha}}" data-contrato="{{$contrato}}" data-contratoid="{{ $resumen->contratoid }}" data-tipo="{{$resumen->tipo_id}}" title="Imprimir pago" id="imprimirReporte"><i class="bi bi-clipboard-data"></i></button>
                                    <button class="btn btn-success ms-1 editar_pago" style="font-size: 13px; padding: 7px" data-bs-toggle="modal" data-bs-target="#formModal" data-pago="{{$pago}}" data-cliente="{{$cliente}}" data-rendimiento="{{$rendimiento}}" data-rendimientoini="{{ $resumen->pago }}" data-fecha="{{$fecha}}" data-contrato="{{$contrato}}" data-contratoid="{{ $resumen->contratoid }}" data-tipo="{{$resumen->tipo_id}}" title="Editar pago" id="editarInput"><i class="bi bi-pencil"></i></button>
                                    <button class="btn btn-primary abrirWhats whats_tabla ms-1" data-pago="{{$pago}}" data-cliente="{{$cliente}}" data-rendimiento="{{$rendimiento}}" data-rendimientoini="{{ $resumen->pago }}" data-fecha="{{ \Carbon\Carbon::parse($fecha)->formatLocalized('%d de %B de %Y') }}" data-contrato="{{$contrato}}" data-clientenumero="{{ $resumen->clientenumero }}" data-tipo="{{$resumen->tipo_id}}" title="Mandar whats para pago por transferencia"><i class="bi bi-whatsapp"></i></button>
                                    <button class="btn btn-primary abrirTrans whatsTrans_tabla ms-1" data-pago="{{$pago}}" data-cliente="{{$cliente}}" data-rendimiento="{{$pago_dolares}}" data-rendimientoini="{{ $resumen->pago }}" data-fecha="{{ \Carbon\Carbon::parse($fecha)->formatLocalized('%d de %B de %Y') }}" data-contrato="{{$contrato}}" data-clientenumero="{{ $resumen->clientenumero }}" data-tipo="{{$resumen->tipo_id}}" title="Mandar whats para pago por transferencia Swissquote"><i class="bi bi-whatsapp"></i></button>

                                    <input id="pagadoStatus" class="status form-check-input fs-6 m-0 p-0 ms-1" type="checkbox" data-id="{{ $resumen->pagoid }}" data-contratoid="{{ $resumen->contratoid }}" data-pago="Compuesto" @if ($resumen->status=="Pagado" ) {{"checked"}} @endif>
                                    <label class="form-check-label ms-1" style="font-size: 15px" for="pagadoStatus">¿Pago realizado?</label>
                                </td>
                            @endif
                        </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="row mt-4" id="contVacio">
        <input type="hidden" value="vacio" id="vacioInput">
        <div class="col-12">
            <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                <symbol id="info-fill" fill="#fff" viewBox="0 0 16 16">
                    <path
                        d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                </symbol>
                <symbol id="exclamation-triangle-fill" fill="#fff" viewBox="0 0 16 16">
                    <path
                        d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                </symbol>
            </svg>
            <div class="alert alert-primary d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
                    aria-label="Info:">
                    <use xlink:href="#info-fill" />
                </svg>
                <div>
                    No se encontraron pagos para esta fecha.
                </div>
            </div>
        </div>
    </div>
@endif

<div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Editar rendimiento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="contratoIdInput">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" placeholder="Ingresa el nombre" id="clienteInput" readonly>
                            <label for="clienteInput">Cliente</label>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" placeholder="Ingresa el rendimiento" id="rendimientoInput">
                            <label for="rendimientoInput">Rendimiento (MXN)</label>
                        </div>
                    </div>
                </div>
                <div class="row d-none">
                    <div class="col-md-6 col-12">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" placeholder="Ingresa el pago" id="pagoInput" readonly>
                            <label for="pagoInput">Pago</label>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" placeholder="Ingresa el fecha" id="fechaInput" readonly>
                            <label for="fechaInput">Fecha</label>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" placeholder="Ingresa el contrato" id="contratoInput" readonly>
                            <label for="contratoInput">Contrato</label>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" placeholder="Ingresa el letra" id="letraInput" readonly>
                            <label for="letraInput">Letra</label>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" placeholder="Ingresa el tipo" id="tipoInput" readonly>
                            <label for="tipoInput">Tipo</label>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" placeholder="Ingresa el reporte" id="reporteInput" readonly>
                            <label for="reporteInput">Tipo</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btnCancel" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn principal-button" id="imprimirReporteModal">Generar reporte</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="formModalWhats" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Mandar WhatsApp</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" style="text-transform: none !important;" placeholder="Ingresa el nombre" id="nombreClienteInput" readonly>
                            <label for="nombreClienteInput">Cliente</label>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" style="text-transform: none !important;" placeholder="Ingresa el nombre" id="numeroClienteInput" readonly>
                            <label for="numeroClienteInput">Número</label>
                        </div>
                    </div>                    
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-floating mb-3">
                            <textarea type="text" class="form-control" placeholder="Ingresa el mensaje" id="mensajeInput" title="Ingresa el mensaje" style="height: 150px; text-transform: none !important;" required></textarea>
                            <label for="floatingInput">Mensaje</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btnCancel" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn principal-button" id="enviarWhats">Enviar WhatsApp</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="formModalNota" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Guardar información de pago</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="notaForm" method="post">
                    @csrf
                    <input type="hidden" name="id" id="idInputNota">
                    <input type="hidden" name="contrato_id" id="contratoIdInputNota">
                    <input type="hidden" name="memo" id="memoInputNota">
                    <input type="hidden" name="pago" id="pagoInputNota">
                    <input type="hidden" name="dolar" id="dolarInputNota">
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
                                <input class="form-check-input" type="checkbox" id="transferenciaInput" name="tipo_pago[]" value="transferencia">
                                <label class="form-check-label" for="transferenciaInput">Transferencia</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="transferenciaSwissInput" name="tipo_pago[]" value="transferenciaSwiss">
                                <label class="form-check-label" for="transferenciaSwissInput">Transferencia de Swissquote</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-12" id="montoEfectivoCont">
                            <div class="form-floating mb-3">
                                <input type="number" step="any" class="form-control" placeholder="Ingresa el monto en efectivo" id="montoEfectivoInput" name="monto[]">
                                <label for="montoEfectivoInput">Monto en efectivo</label>
                            </div>
                        </div>
                        <div class="col-md-12 col-12" id="montoTransferenciaCont">
                            <div class="form-floating mb-3">
                                <div class="form-floating mb-3">
                                    <input type="number" step="any" class="form-control" placeholder="Ingresa el monto en transferencia" id="montoTransferenciaInput" name="monto[]">
                                    <label for="montoTransferenciaInput">Monto en transferencia</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-12" id="montoTransSwissCont">
                            <div class="form-floating mb-3">
                                <input type="number" step="any" class="form-control" placeholder="Ingresa el monto en transferencia Swiss" id="montoTransferenciaSwissInput" name="monto[]">
                                <label for="montoTransferenciaSwissInput">Monto en transferencia Swissquote</label>
                            </div>
                        </div>
                    </div>
                    <div id="alertaNota"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="btnCancel" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn principal-button">Guardar info</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>