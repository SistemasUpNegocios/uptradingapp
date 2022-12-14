@if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos)
<div class="d-flex align-items-center">
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
        class="ms-1 btn btn-primary btn-sm btn-icon view"> <i class="bi bi-eye"></i></a>
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
        data-comprobantepago="{{ $comprobante_pago }}" type="button" title="Editar contrato"
        class="ms-1 btn btn-success btn-sm btn-icon edit"> <i class="bi bi-pencil"></i></a>
    <a href="" data-id="{{ $id }}" type="button" title="Eliminar contrato"
        class="ms-1 btn btn-danger btn-sm btn-icon delete"> <i class="bi bi-trash"></i></a>
    @if ($status == "Activado")
    <a href="" data-id="{{ $id }}" type="button" title="Imprimir contrato"
        class="ms-1 btn btn-primary btn-sm btn-icon print"> <i class="bi bi-printer"></i></a>
    @endif


    @php
    $query = DB::table('contrato_escaneado')
    ->where('contrato_id', $id)
    ->get();
    @endphp

    @if (!$query->first())
    <a href="" data-id="{{ $id }}" data-contrato="{{ $contrato }}" type="button"
        title="No se ha registrado el contrato escaneado" class="ms-1 btn btn-warning btn-sm btn-icon scanner"> <i
            class="bi bi-file-excel"></i></a>
    @else
    @if ($query[0]->img_anverso != null && $query[0]->img_reverso != null)
    <a href="" data-id="{{ $id }}" data-contrato="{{ $contrato }}" type="button" title="Ver contrato escaneado"
        class="ms-1 btn btn-warning btn-sm btn-icon scanner"> <i class="bi bi-file-earmark-spreadsheet"></i></a>
    @else
    <a href="" data-id="{{ $id }}" data-contrato="{{ $contrato }}" type="button"
        title="El registro del contrato escaneado est?? incompleto" class="ms-1 btn btn-warning btn-sm btn-icon scanner">
        <i class="bi bi-file-excel-fill"></i></a>
    @endif
    @endif

    <input id="convenioStatusInput" class="status form-check-input fs-5 m-0 p-0 ms-1" type="checkbox"
        value="{{ $status }}" data-id="{{ $id }}" data-status="{{ $status }}" @if ($status=="Activado" ) {{"checked"}}
        @endif>
    <label class="form-check-label ms-1" for="contratoStatusInput">@if ($status == "Activado") Desactivar contrato @else
        Activar contrato @endif</label>
</div>
@endif

@if (auth()->user()->is_cliente || auth()->user()->is_mexico || auth()->user()->is_cliente_ps_encargado ||
auth()->user()->is_cliente_ps_asistente)
@php
$ps_id = session("psid");
@endphp
@if($ps_id != $psid)
<a href="" data-id="{{ $id }}" data-nombrecliente="{{ $clientenombre }}" data-operador="{{ $operador }}"
    data-operadorine="{{ $operador_ine }}" data-lugarfirma="{{ $lugar_firma }}" data-periodo="{{ $periodo }}"
    data-fecha="{{ $fecha }}" data-fecharen="{{ $fecha_renovacion }}" data-fechapag="{{ $fecha_pago }}"
    data-contrato="{{ $contrato }}" data-psid="{{ $psid }}" data-capertura="{{ $capertura }}"
    data-cmensual="{{ $cmensual }}" data-clienteid="{{ $clienteid }}" data-tipoid="{{ $tipoid }}"
    data-porcentaje="{{ $porcentaje }}" data-folio="{{ $folio }}" data-inversion="{{ $inversion }}"
    data-tipocambio="{{ $tipo_cambio }}" data-inversionus="{{ $inversion_us }}"
    data-inversionlet="{{ $inversion_letra }}" data-inversionletus="{{ $inversion_letra_us }}"
    data-status="{{ $status }}" data-fecharein="{{ $fecha_reintegro }}" data-statusrein="{{ $status_reintegro }}"
    data-memorein="{{ $memo_reintegro }}" data-pendienteid="{{ $pendienteid }}" data-fechalimite="{{ $fecha_limite }}"
    data-tipopago="{{ $tipo_pago }}" data-comprobantepago="{{ $comprobante_pago }}" type="button" title="Vista previa"
    class="ms-1 btn btn-primary btn-sm btn-icon view"> <i class="bi bi-eye"></i> Ver contrato</a>
<a href="" data-id="{{ $id }}" type="button" title="Ver contrato virtual"
    class="ms-1 btn btn-primary btn-sm btn-icon print"> <i class="bi bi-printer"></i> Ver contrato virtual</a>
@endif
@endif

@if (auth()->user()->is_mexico)
<a href="" data-id="{{ $id }}" data-nombrecliente="{{ $clientenombre }}" data-operador="{{ $operador }}"
    data-operadorine="{{ $operador_ine }}" data-lugarfirma="{{ $lugar_firma }}" data-periodo="{{ $periodo }}"
    data-fecha="{{ $fecha }}" data-fecharen="{{ $fecha_renovacion }}" data-fechapag="{{ $fecha_pago }}"
    data-contrato="{{ $contrato }}" data-psid="{{ $psid }}" data-capertura="{{ $capertura }}"
    data-cmensual="{{ $cmensual }}" data-clienteid="{{ $clienteid }}" data-tipoid="{{ $tipoid }}"
    data-porcentaje="{{ $porcentaje }}" data-folio="{{ $folio }}" data-inversion="{{ $inversion }}"
    data-tipocambio="{{ $tipo_cambio }}" data-inversionus="{{ $inversion_us }}"
    data-inversionlet="{{ $inversion_letra }}" data-inversionletus="{{ $inversion_letra_us }}"
    data-status="{{ $status }}" data-fecharein="{{ $fecha_reintegro }}" data-statusrein="{{ $status_reintegro }}"
    data-memorein="{{ $memo_reintegro }}" data-pendienteid="{{ $pendienteid }}" data-fechalimite="{{ $fecha_limite }}"
    data-tipopago="{{ $tipo_pago }}" data-comprobantepago="{{ $comprobante_pago }}" type="button" title="Vista previa"
    class="ms-1 btn btn-primary btn-sm btn-icon view"> <i class="bi bi-eye"></i> Ver contrato</a>
    <div class="d-flex align-items-center">
        <a href="" data-id="{{ $id }}" data-nombrecliente="{{ $clientenombre }}" data-operador="{{ $operador }}" data-operadorine="{{ $operador_ine }}" data-lugarfirma="{{ $lugar_firma }}" data-periodo="{{ $periodo }}" data-fecha="{{ $fecha }}" data-fecharen="{{ $fecha_renovacion }}" data-fechapag="{{ $fecha_pago }}" data-contrato="{{ $contrato }}" data-psid="{{ $psid }}" data-capertura="{{ $capertura }}" data-cmensual="{{ $cmensual }}" data-clienteid="{{ $clienteid }}" data-tipoid="{{ $tipoid }}" data-porcentaje="{{ $porcentaje }}" data-folio="{{ $folio }}" data-inversion="{{ $inversion }}" data-tipocambio="{{ $tipo_cambio }}" data-inversionus="{{ $inversion_us }}" data-inversionlet="{{ $inversion_letra }}" data-inversionletus="{{ $inversion_letra_us }}" data-status="{{ $status }}" data-fecharein="{{ $fecha_reintegro }}" data-statusrein="{{ $status_reintegro }}" data-memorein="{{ $memo_reintegro }}" data-pendienteid="{{ $pendienteid }}" data-fechalimite="{{ $fecha_limite }}" data-tipopago="{{ $tipo_pago }}" data-comprobantepago="{{ $comprobante_pago }}"  type="button" title="Vista previa" class="ms-1 btn btn-primary btn-sm btn-icon view"> <i class="bi bi-eye"></i></a>
        <a href="" data-id="{{ $id }}" data-nombrecliente="{{ $clientenombre }}" data-operador="{{ $operador }}" data-operadorine="{{ $operador_ine }}" data-lugarfirma="{{ $lugar_firma }}" data-periodo="{{ $periodo }}" data-fecha="{{ $fecha }}" data-fecharen="{{ $fecha_renovacion }}" data-fechapag="{{ $fecha_pago }}" data-contrato="{{ $contrato }}" data-psid="{{ $psid }}" data-capertura="{{ $capertura }}" data-cmensual="{{ $cmensual }}" data-clienteid="{{ $clienteid }}" data-tipoid="{{ $tipoid }}" data-porcentaje="{{ $porcentaje }}" data-folio="{{ $folio }}" data-inversion="{{ $inversion }}" data-tipocambio="{{ $tipo_cambio }}" data-inversionus="{{ $inversion_us }}" data-inversionlet="{{ $inversion_letra }}" data-inversionletus="{{ $inversion_letra_us }}" data-status="{{ $status }}" data-fecharein="{{ $fecha_reintegro }}" data-statusrein="{{ $status_reintegro }}" data-memorein="{{ $memo_reintegro }}" data-pendienteid="{{ $pendienteid }}" data-fechalimite="{{ $fecha_limite }}" data-tipopago="{{ $tipo_pago }}" data-comprobantepago="{{ $comprobante_pago }}"  type="button" title="Editar contrato" class="ms-1 btn btn-success btn-sm btn-icon edit"> <i class="bi bi-pencil"></i></a>
        <a href="" data-id="{{ $id }}" type="button" title="Eliminar contrato" class="ms-1 btn btn-danger btn-sm btn-icon delete"> <i class="bi bi-trash"></i></a>
        @if ($status == "Activado")
            <a href="" data-id="{{ $id }}" type="button" title="Imprimir contrato" class="ms-1 btn btn-primary btn-sm btn-icon print"> <i class="bi bi-printer"></i></a>
        @endif
        <input id="convenioStatusInput" class="status form-check-input fs-5 m-0 p-0 ms-1" type="checkbox" value="{{ $status }}" data-id="{{ $id }}" data-status="{{ $status }}" @if ($status == "Activado") {{"checked"}} @endif>
        <label class="form-check-label ms-1" for="contratoStatusInput">@if ($status == "Activado") Desactivar contrato @else Activar contrato @endif</label>
    </div>
@endif

@if (auth()->user()->is_cliente || auth()->user()->is_cliente_ps_encargado || auth()->user()->is_cliente_ps_asistente)
    @php
        $ps_id = session("psid");
    @endphp
    @if($ps_id != $psid)
        <a href="" data-id="{{ $id }}" data-nombrecliente="{{ $clientenombre }}" data-operador="{{ $operador }}" data-operadorine="{{ $operador_ine }}" data-lugarfirma="{{ $lugar_firma }}" data-periodo="{{ $periodo }}" data-fecha="{{ $fecha }}" data-fecharen="{{ $fecha_renovacion }}" data-fechapag="{{ $fecha_pago }}" data-contrato="{{ $contrato }}" data-psid="{{ $psid }}" data-capertura="{{ $capertura }}" data-cmensual="{{ $cmensual }}" data-clienteid="{{ $clienteid }}" data-tipoid="{{ $tipoid }}" data-porcentaje="{{ $porcentaje }}" data-folio="{{ $folio }}" data-inversion="{{ $inversion }}" data-tipocambio="{{ $tipo_cambio }}" data-inversionus="{{ $inversion_us }}" data-inversionlet="{{ $inversion_letra }}" data-inversionletus="{{ $inversion_letra_us }}" data-status="{{ $status }}" data-fecharein="{{ $fecha_reintegro }}" data-statusrein="{{ $status_reintegro }}" data-memorein="{{ $memo_reintegro }}" data-pendienteid="{{ $pendienteid }}" data-fechalimite="{{ $fecha_limite }}" data-tipopago="{{ $tipo_pago }}" data-comprobantepago="{{ $comprobante_pago }}"  type="button" title="Vista previa" class="ms-1 btn btn-primary btn-sm btn-icon view"> <i class="bi bi-eye"></i> Ver contrato</a>
        <a href="" data-id="{{ $id }}"  type="button" title="Ver contrato virtual" class="ms-1 btn btn-primary btn-sm btn-icon print"> <i class="bi bi-printer"></i> Ver contrato virtual</a>
    @endif
@endif

@if (auth()->user()->is_ps_encargado)
    <a href="" data-id="{{ $id }}" data-nombrecliente="{{ $clientenombre }}" data-operador="{{ $operador }}" data-operadorine="{{ $operador_ine }}" data-lugarfirma="{{ $lugar_firma }}" data-periodo="{{ $periodo }}" data-fecha="{{ $fecha }}" data-fecharen="{{ $fecha_renovacion }}" data-fechapag="{{ $fecha_pago }}" data-contrato="{{ $contrato }}" data-psid="{{ $psid }}" data-capertura="{{ $capertura }}" data-cmensual="{{ $cmensual }}" data-clienteid="{{ $clienteid }}" data-tipoid="{{ $tipoid }}" data-porcentaje="{{ $porcentaje }}" data-folio="{{ $folio }}" data-inversion="{{ $inversion }}" data-tipocambio="{{ $tipo_cambio }}" data-inversionus="{{ $inversion_us }}" data-inversionlet="{{ $inversion_letra }}" data-inversionletus="{{ $inversion_letra_us }}" data-status="{{ $status }}" data-fecharein="{{ $fecha_reintegro }}" data-statusrein="{{ $status_reintegro }}" data-memorein="{{ $memo_reintegro }}" data-pendienteid="{{ $pendienteid }}" data-fechalimite="{{ $fecha_limite }}" data-tipopago="{{ $tipo_pago }}" data-comprobantepago="{{ $comprobante_pago }}"  type="button" title="Vista previa" class="ms-1 btn btn-primary btn-sm btn-icon view"> <i class="bi bi-eye"></i> Ver contrato</a>
@endif