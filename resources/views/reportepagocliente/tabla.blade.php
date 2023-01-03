@if (sizeof($resumenes_contrato) > 0)    
    <table class="table table-striped table-bordered nowrap text-center" style="width: 100%" id="resumen">
        <thead>
            <tr>
                <th data-priority="0" scope="col">Contrato</th>
                <th data-priority="0" scope="col">Cliente</th>
                <th data-priority="0" scope="col">Rendimiento (MXN)</th>
                <th data-priority="0" scope="col">Pago</th>
                <th data-priority="0" scope="col">Reporte</th>
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
                    if ($resumen->tipo_id == 1){
                        $pago = str_pad($resumen->serie_pago, 2, "0", STR_PAD_LEFT).'/12';
                    }
                    $fecha = $resumen->fecha;
                @endphp
                @if ($resumen->tipo_id == 1)                                    
                    <tr>
                        <td>
                            {{ $contrato }}
                        </td>
                        <td>{{ $cliente }}</td>
                        <td>${{ $rendimiento }}</td>
                        <td>
                            {{ $pago }}
                        </td>
                        <td>
                            <button class="btn btn-warning" data-pago="{{$pago}}" data-cliente="{{$cliente}}" data-rendimiento="{{$rendimiento}}" data-rendimientoini="{{ $resumen->pago }}" data-fecha="{{$fecha}}" data-contrato="{{$contrato}}" data-contratoid="{{ $resumen->contratoid }}" title="Imprimir pago" id="imprimirReporte"><i class="bi bi-clipboard-data"></i></button>

                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#formModal"  data-pago="{{$pago}}" data-cliente="{{$cliente}}" data-rendimiento="{{$rendimiento}}" data-rendimientoini="{{ $resumen->pago }}" data-fecha="{{$fecha}}" data-contrato="{{$contrato}}" title="Editar pago" id="editarInput"><i class="bi bi-pencil"></i></button>
                        </td>
                    </tr>
                @elseif ($resumen->tipo_id == 2 && $resumen->serie_pago == 12)
                    <tr>
                        <td>
                            {{ $contrato }}
                        </td>
                        <td>{{ $cliente }}</td>
                        <td>${{ $rendimiento }}</td>
                        <td>Compuesto</td>
                        <td>
                            <button class="btn btn-warning" data-pago="{{$pago}}" data-cliente="{{$cliente}}" data-rendimiento="{{$rendimiento}}" data-rendimientoini="{{ $resumen->pago }}" data-fecha="{{$fecha}}" data-contrato="{{$contrato}}" data-contratoid="{{ $resumen->contratoid }}" title="Imprimir pago" id="imprimirReporte"><i class="bi bi-clipboard-data"></i></button>

                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#formModal"  data-pago="{{$pago}}" data-cliente="{{$cliente}}" data-rendimiento="{{$rendimiento}}" data-rendimientoini="{{ $resumen->pago }}" data-fecha="{{$fecha}}" data-contrato="{{$contrato}}" title="Editar pago" id="editarInput"><i class="bi bi-pencil"></i></button>
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
@else
    <div class="row" id="contVacio">
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btnCancel" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn principal-button" id="imprimirReporteModal">Generar reporte</button>
                </div>
            </div>
        </div>
    </div>
</div>