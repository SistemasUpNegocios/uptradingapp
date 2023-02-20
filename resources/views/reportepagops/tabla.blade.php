<div class="mt-4" style="overflow-x: auto;">
    <table class="table table-striped table-bordered nowrap text-center" style="width: 100%" id="resumenPagoPs">
        <thead>
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
                    $codigo = session('codigo_oficina');
                    $comision_ps = DB::table('contrato')
                        ->join('ps', 'ps.id', '=', 'contrato.ps_id')
                        ->join('oficina', 'oficina.id', '=', 'ps.oficina_id')
                        ->join('pago_ps', 'pago_ps.contrato_id', '=', 'contrato.id')
                        ->where('pago_ps.fecha_limite', 'like', "$fecha%")
                        ->where('contrato.ps_id', $ps->id)
                        ->where("contrato.status", "Activado")
                        ->where('ps.codigoPS', '!=', "IA1")
                        ->where('ps.codigoPS', '!=', "IA2")
                        ->where('ps.codigoPS', '!=', "IA3")
                        ->orderBy('ps.id', 'DESC')
                        ->sum('pago_ps.pago');
                    
                    $comision = number_format($comision_ps * $dolar, 2);
                    $comision_dolares = number_format($comision_ps, 2);
                @endphp
                @if ($comision_ps > 0)
                    <tr>
                        <td style="font-size: 14px">{{ $ps->nombre }} {{ $ps->apellido_p }} {{ $ps->apellido_m }}</td>
                        <td style="font-size: 14px">${{ $comision }}</td>
                        <td style="font-size: 14px">${{ $comision_dolares }}</td>
                        <td>
                            <button class="btn btn-warning" style="font-size: 13px; padding: 7px" data-ps="{{ $ps->nombre }} {{ $ps->apellido_p }} {{ $ps->apellido_m }}" data-comision="{{$comision}}" data-comisiondolares="{{ $comision_dolares }}" data-fecha="{{ $fecha }}" title="Imprimir pago" id="imprimirReporte"><i class="bi bi-clipboard-data"></i></button>
                            <button class="btn btn-success" style="font-size: 13px; padding: 7px" data-bs-toggle="modal" data-bs-target="#formModal" data-ps="{{ $ps->nombre }} {{ $ps->apellido_p }} {{ $ps->apellido_m }}" data-comision="{{$comision}}" data-comisiondolares="{{ $comision_dolares }}" data-fecha="{{ $fecha }}" title="Editar pago" id="editarInput"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-primary abrirWhats whats_tabla" data-ps="{{ $ps->nombre }} {{ $ps->apellido_p }} {{ $ps->apellido_m }}" data-comision="{{$comision}}" data-comisiondolares="{{ $comision_dolares }}" data-psnumero="{{ $ps->celular }}" title="Mandar whats para pago en efectivo"><i class="bi bi-whatsapp"></i></button>
                            <button class="btn btn-primary abrirTrans whatsTrans_tabla" data-ps="{{ $ps->nombre }} {{ $ps->apellido_p }} {{ $ps->apellido_m }}" data-comision="{{$comision}}" data-comisiondolares="{{ $comision_dolares }}" data-psnumero="{{ $ps->celular }}" data-fecha="{{ \Carbon\Carbon::parse($fecha)->formatLocalized('%B') }}" title="Mandar whats para pago por transferencia"><i class="bi bi-whatsapp"></i></button>
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