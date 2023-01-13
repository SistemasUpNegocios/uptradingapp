@if (auth()->user()->is_root)
    <div class="d-flex align-items-center justify-content-center">
        <a href="" data-id="{{ $id }}" data-nombrecliente="{{ $clientenombre }}" data-operador="{{ $operador }}" data-operadorine="{{ $operador_ine }}" data-lugarfirma="{{ $lugar_firma }}" data-periodo="{{ $periodo }}" data-fecha="{{ $fecha }}" data-fecharen="{{ $fecha_renovacion }}" data-fechapag="{{ $fecha_pago }}" data-contrato="{{ $contrato }}" data-psid="{{ $psid }}" data-capertura="{{ $capertura }}" data-cmensual="{{ $cmensual }}" data-clienteid="{{ $clienteid }}" data-tipoid="{{ $tipoid }}" data-porcentaje="{{ $porcentaje }}" data-folio="{{ $folio }}" data-inversion="{{ $inversion }}" data-tipocambio="{{ $tipo_cambio }}" data-inversionus="{{ $inversion_us }}" data-inversionlet="{{ $inversion_letra }}" data-inversionletus="{{ $inversion_letra_us }}" data-status="{{ $status }}" data-fecharein="{{ $fecha_reintegro }}" data-statusrein="{{ $status_reintegro }}" data-memorein="{{ $memo_reintegro }}" data-pendienteid="{{ $pendienteid }}" data-fechalimite="{{ $fecha_limite }}" data-tipopago="{{ $tipo_pago }}" data-comprobantepago="{{ $comprobante_pago }}"  type="button" title="Vista previa" class="ms-1 btn btn-primary btn-sm btn-icon view"> <i class="bi bi-eye"></i></a>
        <a href="" data-id="{{ $id }}" data-nombrecliente="{{ $clientenombre }}" data-operador="{{ $operador }}" data-operadorine="{{ $operador_ine }}" data-lugarfirma="{{ $lugar_firma }}" data-periodo="{{ $periodo }}" data-fecha="{{ $fecha }}" data-fecharen="{{ $fecha_renovacion }}" data-fechapag="{{ $fecha_pago }}" data-contrato="{{ $contrato }}" data-psid="{{ $psid }}" data-capertura="{{ $capertura }}" data-cmensual="{{ $cmensual }}" data-clienteid="{{ $clienteid }}" data-tipoid="{{ $tipoid }}" data-porcentaje="{{ $porcentaje }}" data-folio="{{ $folio }}" data-inversion="{{ $inversion }}" data-tipocambio="{{ $tipo_cambio }}" data-inversionus="{{ $inversion_us }}" data-inversionlet="{{ $inversion_letra }}" data-inversionletus="{{ $inversion_letra_us }}" data-status="{{ $status }}" data-fecharein="{{ $fecha_reintegro }}" data-statusrein="{{ $status_reintegro }}" data-memorein="{{ $memo_reintegro }}" data-pendienteid="{{ $pendienteid }}" data-fechalimite="{{ $fecha_limite }}" data-tipopago="{{ $tipo_pago }}" data-comprobantepago="{{ $comprobante_pago }}"  type="button" title="Editar contrato" class="ms-1 btn btn-success btn-sm btn-icon edit"> <i class="bi bi-pencil"></i></a>
        <a href="" data-id="{{ $id }}" type="button" title="Eliminar contrato" class="ms-1 btn btn-danger btn-sm btn-icon delete"> <i class="bi bi-trash"></i></a>
    </div>
@elseif (auth()->user()->is_egresos || auth()->user()->is_admin || auth()->user()->is_procesos)
    <a href="" data-id="{{ $id }}" data-nombrecliente="{{ $clientenombre }}" data-operador="{{ $operador }}" data-operadorine="{{ $operador_ine }}" data-lugarfirma="{{ $lugar_firma }}" data-periodo="{{ $periodo }}" data-fecha="{{ $fecha }}" data-fecharen="{{ $fecha_renovacion }}" data-fechapag="{{ $fecha_pago }}" data-contrato="{{ $contrato }}" data-psid="{{ $psid }}" data-capertura="{{ $capertura }}" data-cmensual="{{ $cmensual }}" data-clienteid="{{ $clienteid }}" data-tipoid="{{ $tipoid }}" data-porcentaje="{{ $porcentaje }}" data-folio="{{ $folio }}" data-inversion="{{ $inversion }}" data-tipocambio="{{ $tipo_cambio }}" data-inversionus="{{ $inversion_us }}" data-inversionlet="{{ $inversion_letra }}" data-inversionletus="{{ $inversion_letra_us }}" data-status="{{ $status }}" data-fecharein="{{ $fecha_reintegro }}" data-statusrein="{{ $status_reintegro }}" data-memorein="{{ $memo_reintegro }}" data-pendienteid="{{ $pendienteid }}" data-fechalimite="{{ $fecha_limite }}" data-tipopago="{{ $tipo_pago }}" data-comprobantepago="{{ $comprobante_pago }}"  type="button" title="Vista previa" class="ms-1 btn btn-primary btn-sm btn-icon view"> <i class="bi bi-eye"></i> Ver contrato</a>
@endif