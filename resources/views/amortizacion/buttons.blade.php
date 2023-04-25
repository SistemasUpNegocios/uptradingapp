@if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_ps_gold || auth()->user()->is_cliente || auth()->user()->is_egresos)
    <a href="" data-contratoid="{{ $contratoid }}" data-contrato="{{ $contrato }}" data-serie="{{ $serie }}" data-fecha="{{ $fecha }}" data-monto="{{ $monto }}" data-redito="{{ $redito }}" data-saldoredito="{{ $saldoredito }}" data-memo="{{ $memo }}" type="button" title="Vista previa" class="btn btn-primary btn-sm btn-icon view"> <i class="bi bi-eye me-1"></i>Ver amortización</a>
@endif
@if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos)
    <a data-id="{{ $id }}" type="button" title="Imprimir contrato" class="btn btn-primary btn-sm btn-icon print"> <i class="bi bi-printer"></i></a>
@endif
