<a href="" data-id="{{ $id }}" data-nombrecliente="{{ $clientenombre }}" data-operador="{{ $operador }}"
    data-operadorine="{{ $operador_ine }}" data-lugarfirma="{{ $lugar_firma }}" data-periodo="{{ $periodo }}"
    data-fecha="{{ $fecha }}" data-fecharen="{{ $fecha_renovacion }}" data-fechapag="{{ $fecha_pago }}"
    data-contrato="{{ $contrato }}" data-psid="{{ $psid }}" data-psnombre="{{ $psnombre }}" data-capertura="{{ $capertura }}"
    data-cmensual="{{ $cmensual }}" data-clienteid="{{ $clienteid }}" data-tipoid="{{ $tipoid }}"
    data-porcentaje="{{ $porcentaje }}" data-folio="{{ $folio }}" data-inversion="{{ $inversion }}"
    data-tipocambio="{{ $tipo_cambio }}" data-inversionus="{{ $inversion_us }}"
    data-inversionlet="{{ $inversion_letra }}" data-inversionletus="{{ $inversion_letra_us }}"
    data-status="{{ $status }}" data-fecharein="{{ $fecha_reintegro }}" data-statusrein="{{ $status_reintegro }}"
    data-memorein="{{ $memo_reintegro }}" data-pendienteid="{{ $pendienteid }}"
    data-fechalimite="{{ $fecha_limite }}" data-tipopago="{{ $tipo_pago }}" data-montopago="{{ $monto_pago }}"
    data-comprobantepago="{{ $comprobante_pago }}" type="button" title="Vista previa"
    class="ms-1 btn btn-primary btn-sm btn-icon view"> <i class="bi bi-eye"></i> Ver contrato</a>

<a href="" data-id="{{ $id }}" data-cliente="{{$clientenombre}}" data-notacontrato="{{$nota_contrato}}" data-contrato="{{$contrato}}" type="button" title="Nota del contrato" class="ms-1 btn @if ($nota_contrato == null) btn-dark @else btn-secondary @endif btn-sm btn-icon edit"> <i class="bi bi-journal-text"></i> Nota</a>

@if(auth()->user()->is_root)
    <div class="d-flex align-items-center justify-content-center mt-2">
        <input id="{{$id}}Input" name="autorizacion_nota" class="autorizado form-check-input fs-6 m-0 p-0 ms-1" type="checkbox" data-id="{{$id}}" @if ($autorizacion_nota=="SI" ) {{"checked"}} @endif>
        <label class="form-check-label ms-1" style="font-size: 15px" for="{{$id}}Input">¿Autorizado?</label>
    </div>
@endif