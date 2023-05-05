<div class="mt-4" style="overflow-x: auto;">
    <table class="table table-striped table-bordered nowrap text-center" style="width: 100%; vertical-align: middle" id="resumenPagoPs">
        <thead style="vertical-align: middle">
            <tr>
                <th style="font-size: 14px !important; width: 30px !important;" data-priority="0" scope="col">PS</th>
                <th style="font-size: 14px !important; width: 30px !important;" data-priority="0" scope="col">Comisión (MXN)</th>
                <th style="font-size: 14px !important; width: 30px !important;" data-priority="0" scope="col">Comisión (USD)</th>
                <th style="font-size: 14px !important; width: 30px !important;" data-priority="0" scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody id="resumenBody" style="vertical-align: middle">
            @foreach ($lista_ps as $ps)
                @php
                    $comision_ps = DB::table('contrato')
                        ->join('ps', 'ps.id', '=', 'contrato.ps_id')
                        ->join('pago_ps', 'pago_ps.contrato_id', '=', 'contrato.id')
                        ->where('pago_ps.fecha_limite', 'like', "$fecha%")
                        ->where('contrato.ps_id', $ps->id)
                        ->where("contrato.status", "Activado")
                        ->where('ps.codigoPS', '!=', "IA1")
                        ->where('ps.codigoPS', '!=', "IA2")
                        ->where('ps.codigoPS', '!=', "IA3")
                        ->orderBy('ps.id', 'DESC')
                        ->sum('pago_ps.pago');

                    $comision_convenio_ps = DB::table('convenio')
                        ->join('ps', 'ps.id', '=', 'convenio.ps_id')
                        ->join('pago_ps_convenio', 'pago_ps_convenio.convenio_id', '=', 'convenio.id')
                        ->where('pago_ps_convenio.fecha_limite', 'like', "$fecha%")
                        ->where('convenio.ps_id', $ps->id)
                        ->where("convenio.status", "Activado")
                        ->where('ps.codigoPS', '!=', "IA1")
                        ->where('ps.codigoPS', '!=', "IA2")
                        ->where('ps.codigoPS', '!=', "IA3")
                        ->orderBy('ps.id', 'DESC')
                        ->sum('pago_ps_convenio.pago');

                    $comision_ps = $comision_ps + $comision_convenio_ps;

                    $status_pago = DB::table('contrato')
                        ->join('ps', 'ps.id', '=', 'contrato.ps_id')
                        ->join('pago_ps', 'pago_ps.contrato_id', '=', 'contrato.id')
                        ->select('pago_ps.id', 'pago_ps.status', 'contrato.id AS contratoid')
                        ->where('pago_ps.fecha_limite', 'like', "$fecha%")
                        ->where('contrato.ps_id', $ps->id)
                        ->where("contrato.status", "Activado")
                        ->where('ps.codigoPS', '!=', "IA1")
                        ->where('ps.codigoPS', '!=', "IA2")
                        ->where('ps.codigoPS', '!=', "IA3")
                        ->orderBy('ps.id', 'DESC')
                        ->get();

                    $pagos = "";
                    $status = "";
                    foreach ($status_pago as $status) {
                        $pagos .= $status->id.',';

                        if(strlen($status->status) > 0){
                            $status = $status->status;
                        }
                    } 
                    
                    $contratoid = "";
                    foreach ($status_pago as $contrato) {
                        $contratoid .= $contrato->contratoid.',';
                    }  

                    $comision = number_format($comision_ps * $dolar, 2);
                    $comision_dolares = number_format($comision_ps, 2);
                    

                    $contrato_id = App\Models\Contrato::where('ps_id', $ps->id)->orderBy("id", "DESC")->first();
                    if(!empty($contrato_id->id)){
                        $pagos_bd = App\Models\Pago::where('id_contrato', $contrato_id->id)->orderBy("id", "DESC")->first();

                        if(!empty($pagos_bd->id)){
                            $consulta = "true";
                        }else{
                            $consulta = "false";
                        }
                    }

                @endphp
                @if ($comision_ps > 0)
                    <tr>
                        <td style="font-size: 14px">{{ $ps->nombre }} {{ $ps->apellido_p }} {{ $ps->apellido_m }}</td>
                        <td style="font-size: 14px">${{ $comision }}</td>
                        <td style="font-size: 14px">${{ $comision_dolares }}</td>
                        <td class="d-flex align-items-center">
                            {{-- @if($consulta == "true")
                                <button title="Información de pago" class="btn btn-secondary nota ms-1" style="font-size: 13px; padding: 7px" data-pagoid="{{$pagos}}" data-contratoid="{{$contratoid}}" data-pesos="{{ $comision }}" data-dolares="{{$comision_dolares}}" data-id="{{$pagos_bd->id}}" data-monto="{{$pagos_bd->monto}}" data-tipopago="{{$pagos_bd->tipo_pago}}"> <i class="bi bi-journal-text"></i></button>
                            @else
                                <button title="Información de pago" class="btn btn-dark nota ms-1" style="font-size: 13px; padding: 7px" data-pagoid="{{$pagos}}" data-contratoid="{{$contratoid}}" data-pesos="{{ $comision }}" data-dolares="{{$comision_dolares}}"> <i class="bi bi-journal-text"></i></button>
                            @endif --}}
                            <button class="btn btn-warning ms-1" style="font-size: 13px; padding: 7px" data-ps="{{ $ps->nombre }} {{ $ps->apellido_p }} {{ $ps->apellido_m }}" data-comision="{{$comision}}" data-comisiondolares="{{ $comision_dolares }}" data-fecha="{{ $fecha }}" title="Imprimir pago" id="imprimirReporte"><i class="bi bi-clipboard-data"></i></button>
                            <button class="btn btn-success ms-1" style="font-size: 13px; padding: 7px" data-bs-toggle="modal" data-bs-target="#formModal" data-ps="{{ $ps->nombre }} {{ $ps->apellido_p }} {{ $ps->apellido_m }}" data-comision="{{$comision}}" data-comisiondolares="{{ $comision_dolares }}" data-fecha="{{ $fecha }}" title="Editar pago" id="editarInput"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-primary abrirWhats whats_tabla ms-1" data-ps="{{ $ps->nombre }} {{ $ps->apellido_p }} {{ $ps->apellido_m }}" data-comision="{{$comision}}" data-comisiondolares="{{ $comision_dolares }}" data-psnumero="{{ $ps->celular }}" data-fecha="{{ \Carbon\Carbon::parse($fecha)->formatLocalized('%B') }}" title="Mandar whats para pesos"><i class="bi bi-whatsapp"></i></button>
                            <button class="btn btn-primary abrirTrans whatsTrans_tabla ms-1" data-ps="{{ $ps->nombre }} {{ $ps->apellido_p }} {{ $ps->apellido_m }}" data-comision="{{$comision}}" data-comisiondolares="{{ $comision_dolares }}" data-psnumero="{{ $ps->celular }}" data-fecha="{{ \Carbon\Carbon::parse($fecha)->formatLocalized('%B') }}" title="Mandar whats para dolares"><i class="bi bi-whatsapp"></i></button>

                            <input id="pagadoStatus" class="status form-check-input fs-6 m-0 p-0 ms-1" type="checkbox" data-id="{{ $pagos }}" @if ($status == "Pagado" ) {{"checked"}} @endif>
                            <label class="form-check-label ms-1" style="font-size: 15px" for="pagadoStatus">¿Pago realizado?</label> 
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>

<div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Editar comision</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="contratoIdInput">
                <div class="row">
                    <div class="col-md-12 col-12">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" placeholder="Ingresa el nombre" id="psInput" readonly>
                            <label for="psInput">PS</label>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" placeholder="Ingresa la comisión" id="comisionInput">
                            <label for="comisionInput">Comisión (MXN)</label>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" placeholder="Ingresa la comisión" id="comisionDolaresInput">
                            <label for="comisionDolaresInput">Comisión (USD)</label>
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
                            <input type="text" class="form-control" placeholder="Ingresa el contrato" id="letraInput" readonly>
                            <label for="letraInput">Letra</label>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" placeholder="Ingresa el letra" id="letraDolaresInput" readonly>
                            <label for="letraDolaresInput">Letra dólares</label>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" placeholder="Ingresa la fecha" id="fechaMesInput" readonly>
                            <label for="fechaMesInput">Fecha</label>
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

<div class="modal fade" id="formModalWhats" tabindex="-1" aria-labelledby="modalTitleWhats" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleWhats">Mandar WhatsApp</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" style="text-transform: none !important;" placeholder="Ingresa el nombre" id="nombrePsInput" readonly>
                            <label for="nombrePsInput">PS</label>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" style="text-transform: none !important;" placeholder="Ingresa el nombre" id="numeroPsInput" readonly>
                            <label for="numeroPsInput">Número</label>
                        </div>
                    </div>                    
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-floating mb-3">
                            <textarea type="text" class="form-control" placeholder="Ingresa el mensaje" id="mensajeInput" style="height: 150px; text-transform: none !important;" required></textarea>
                            <label for="mensajeInput">Mensaje</label>
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