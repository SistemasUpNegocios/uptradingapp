@if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_ps_diamond)
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
            data-memorein="{{ $memo_reintegro }}"
            data-fechalimite="{{ $fecha_limite }}" data-tipopago="{{ $tipo_pago }}" data-montopago="{{ $monto_pago }}" data-referencia="{{ $referencia_pago }}"
            data-comprobantepago="{{ $comprobante_pago }}" type="button" title="Vista previa"
            class="ms-1 btn btn-primary btn-sm btn-icon view"> <i class="bi bi-eye"></i></a>
        @if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos)    
            <a href="" data-id="{{ $id }}" data-nombrecliente="{{ $clientenombre }}" data-operador="{{ $operador }}"
                data-operadorine="{{ $operador_ine }}" data-lugarfirma="{{ $lugar_firma }}" data-periodo="{{ $periodo }}"
                data-fecha="{{ $fecha }}" data-fecharen="{{ $fecha_renovacion }}" data-fechapag="{{ $fecha_pago }}"
                data-contrato="{{ $contrato }}" data-psid="{{ $psid }}" data-psnombre="{{ $psnombre }}" data-capertura="{{ $capertura }}"
                data-cmensual="{{ $cmensual }}" data-clienteid="{{ $clienteid }}" data-tipoid="{{ $tipoid }}"
                data-porcentaje="{{ $porcentaje }}" data-folio="{{ $folio }}" data-inversion="{{ $inversion }}"
                data-tipocambio="{{ $tipo_cambio }}" data-inversionus="{{ $inversion_us }}"
                data-inversionlet="{{ $inversion_letra }}" data-inversionletus="{{ $inversion_letra_us }}"
                data-status="{{ $status }}" data-fecharein="{{ $fecha_reintegro }}" data-statusrein="{{ $status_reintegro }}"
                data-memorein="{{ $memo_reintegro }}"
                data-fechalimite="{{ $fecha_limite }}" data-tipopago="{{ $tipo_pago }}" data-montopago="{{ $monto_pago }}"
                data-referencia="{{ $referencia_pago }}"
                data-comprobantepago="{{ $comprobante_pago }}" type="button" title="Editar contrato"
                class="ms-1 btn btn-success btn-sm btn-icon edit"> <i class="bi bi-pencil"></i></a>
            <a href="" data-id="{{ $id }}" type="button" title="Eliminar contrato"
                class="ms-1 btn btn-danger btn-sm btn-icon delete"> <i class="bi bi-trash"></i></a>

            @if ($status == "Activado")
                <a href="" data-id="{{ $id }}" type="button" title="Imprimir contrato" class="ms-1 btn btn-primary btn-sm btn-icon print"> <i class="bi bi-printer"></i></a>
            @endif
        @endif


        @php
            $query = DB::table('contrato_escaneado')
                ->where('contrato_id', $id)
                ->get();
        @endphp

        @if (!$query->first())
            <a href="" data-id="{{ $id }}" data-contrato="{{ $contrato }}" type="button" title="No se ha registrado el contrato escaneado" class="ms-1 btn btn-warning btn-sm btn-icon scanner"> <i class="bi bi-file-excel"></i></a>
        @else
            <a href="" data-id="{{ $id }}" data-contrato="{{ $contrato }}" type="button" title="Ver contrato escaneado" class="ms-1 btn btn-warning btn-sm btn-icon scanner"> <i class="bi bi-file-earmark-spreadsheet"></i></a>
        @endif

        @if (auth()->user()->is_root)    
            <input id="contratoStatusInputs" class="status form-check-input fs-5 m-0 p-0 ms-1" type="checkbox" value="{{ $status }}" data-id="{{ $id }}" data-status="{{ $status }}" data-celular="{{ $celular }}" data-contrato="{{ $contrato }}" @if ($status=="Activado" ) {{"checked"}} @endif>
            <label class="form-check-label ms-1" for="contratoStatusInput">@if ($status == "Activado") Desactivar contrato @else Activar contrato @endif</label>
        @endif
    </div>
@endif

@if (auth()->user()->is_ps_gold || auth()->user()->is_cliente || auth()->user()->is_egresos )
    <a href="" data-id="{{ $id }}" data-nombrecliente="{{ $clientenombre }}" data-operador="{{ $operador }}" data-operadorine="{{ $operador_ine }}" data-lugarfirma="{{ $lugar_firma }}" data-periodo="{{ $periodo }}" data-fecha="{{ $fecha }}" data-fecharen="{{ $fecha_renovacion }}" data-fechapag="{{ $fecha_pago }}" data-contrato="{{ $contrato }}" data-psid="{{ $psid }}" data-capertura="{{ $capertura }}" data-cmensual="{{ $cmensual }}" data-clienteid="{{ $clienteid }}" data-tipoid="{{ $tipoid }}" data-porcentaje="{{ $porcentaje }}" data-folio="{{ $folio }}" data-inversion="{{ $inversion }}" data-tipocambio="{{ $tipo_cambio }}" data-inversionus="{{ $inversion_us }}" data-inversionlet="{{ $inversion_letra }}" data-inversionletus="{{ $inversion_letra_us }}" data-status="{{ $status }}" data-fecharein="{{ $fecha_reintegro }}" data-statusrein="{{ $status_reintegro }}" data-memorein="{{ $memo_reintegro }}" data-fechalimite="{{ $fecha_limite }}" data-tipopago="{{ $tipo_pago }}" data-montopago="{{ $monto_pago }}" data-comprobantepago="{{ $comprobante_pago }}" data-referencia="{{ $referencia_pago }}" data-psnombre="{{ $psnombre }}" type="button" title="Vista previa" class="ms-1 btn btn-primary btn-sm btn-icon view"> <i class="bi bi-eye"></i> Ver contrato</a>
@endif