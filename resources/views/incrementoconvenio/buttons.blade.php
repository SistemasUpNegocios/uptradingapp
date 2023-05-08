@if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos)
    <div class="d-flex align-items-center justify-content-center">
        <a href="" data-id="{{ $id }}" data-folio="{{ $folio }}" data-firma="{{$firma}}" data-nombrecliente="{{ $clientenombre }}" data-psnombre="{{ $psnombre }}" data-monto="{{ $cantidad_incremento }}" data-monto_letra="{{ $cantidad_incrementoletra }}" data-fecha_inicio="{{ $fecha_inicio_incremento }}" data-status="{{ $status }}" data-ps_id="{{ $ps_id }}" data-cliente_id="{{ $cliente_id }}" data-convenio_id="{{ $convenioid }}" type="button" title="Vista previa" class="ms-1 btn btn-primary btn-sm btn-icon view"> <i class="bi bi-eye"></i></a>
        <a href="" data-id="{{ $id }}" data-folio="{{ $folio }}" data-firma="{{$firma}}" data-nombrecliente="{{ $clientenombre }}" data-psnombre="{{ $psnombre }}" data-monto="{{ $cantidad_incremento }}" data-monto_letra="{{ $cantidad_incrementoletra }}" data-fecha_inicio="{{ $fecha_inicio_incremento }}" data-status="{{ $status }}" data-ps_id="{{ $ps_id }}" data-cliente_id="{{ $cliente_id }}" data-convenio_id="{{ $convenioid }}" type="button" title="Editar convenio" class="ms-1 btn btn-success btn-sm btn-icon edit"> <i class="bi bi-pencil"></i></a>
        <a href="" data-id="{{ $id }}" type="button" title="Eliminar convenio" class="ms-1 btn btn-danger btn-sm btn-icon delete"> <i class="bi bi-trash"></i></a>

        @if ($status == "Activado")
            <a href="" data-id="{{ $id }}" type="button" title="Imprimir convenio" class="ms-1 btn btn-primary btn-sm btn-icon print"> <i class="bi bi-printer"></i></a> 
        @endif

        @php
            $convenio_oficina = App\Models\Log::join("bitacora_acceso", "bitacora_acceso.id", "=", "logs.bitacora_id")
                ->join("users", "users.id", "=", "bitacora_acceso.user_id")
                ->select("users.correo")
                ->where("logs.id_tabla", $id)
                ->where("logs.tipo_accion", "Inserción")
                ->where("logs.tabla", "IncrementoConvenio")
                ->first();

            if(!empty($convenio_oficina)){
                $ps_cons = App\Models\Ps::select()->where("correo_institucional", strtolower($convenio_oficina->correo))->first();
            }
        @endphp
        @if (auth()->user()->is_admin || auth()->user()->is_procesos)
            @if(!empty($convenio_oficina) && !empty($ps_cons->oficina_id))
                @if ($ps_cons->oficina_id  != 1 && $status == "Pendiente de activación")
                    <input id="convenioStatusInputOficina" class="status_oficina form-check-input fs-5 m-0 p-0 ms-1" type="checkbox" value="{{ $status_oficina }}" data-id="{{ $id }}" data-status="{{ $status_oficina }}" @if ($status_oficina == "Activado") {{"checked"}} @endif>
                    <label class="form-check-label ms-1" for="convenioStatusInput">@if ($status_oficina == "Activado") Rechazar convenio @else Aceptar convenio @endif</label>
                @endif
            @endif
        @elseif (auth()->user()->is_root)
            @if ($status_oficina == "Activado")
                <input id="convenioStatusInput" class="status form-check-input fs-5 m-0 p-0 ms-1" type="checkbox" value="{{ $status }}" data-id="{{ $id }}" data-status="{{ $status }}" @if ($status == "Activado") {{"checked"}} @endif>
                <label class="form-check-label ms-1" for="convenioStatusInput">@if ($status == "Activado") Desactivar convenio @else Activar convenio @endif</label>
            @endif
        @endif
    </div>
@endif
@if (auth()->user()->is_egresos || auth()->user()->is_ps_gold || auth()->user()->is_cliente || auth()->user()->is_ps_diamond || auth()->user()->is_ps_bronze)
    <a href="" ddata-folio="{{ $folio }}" data-firma="{{$firma}}" data-nombrecliente="{{ $clientenombre }}" data-psnombre="{{ $psnombre }}" data-monto="{{ $cantidad_incremento }}" data-monto_letra="{{ $cantidad_incrementoletra }}" data-fecha_inicio="{{ $fecha_inicio_incremento }}" data-status="{{ $status }}" data-ps_id="{{ $ps_id }}" data-cliente_id="{{ $cliente_id }}" data-convenio_id="{{ $convenioid }}" type="button" title="Vista previa" class="ms-1 btn btn-primary btn-sm btn-icon view"> <i class="bi bi-eye"></i> Ver convenio</a>
@endif