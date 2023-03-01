@if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos)
<div class="d-flex w-100 align-items-center justify-content-center">
<a href="" id="seeClausulas" data-tipoid="{{ $id }}" class="btn btn-primary btn-sm me-1">Ver cláusulas</a>
<a href="" data-tipo="{{ $tipo }}" data-redaccion="{{ $redaccion }}" data-capertura="{{ $capertura }}" data-cmensual="{{ $cmensual }}" data-rendimiento="{{ $rendimiento }}" data-nombremodelo="{{ $nombremodelo }}" data-modeloid="{{ $modeloid }}" data-tabla="{{$tabla}}" type="button" title="Vista previa" class="btn btn-primary btn-sm btn-icon view me-1"> <i class="bi bi-eye"></i></a>
<a href="" data-id="{{ $id }}" data-tipo="{{ $tipo }}" data-redaccion="{{ $redaccion }}" data-capertura="{{ $capertura }}" data-cmensual="{{ $cmensual }}" data-rendimiento="{{ $rendimiento }}" data-nombremodelo="{{ $nombremodelo }}" data-modeloid="{{ $modeloid }}" data-tabla="{{$tabla}}" type="button" title="Editar tipo de contrato" class="btn btn-success btn-sm btn-icon edit me-1"> <i class="bi bi-pencil"></i></a>
<a href="" data-id="{{ $id }}" type="button" title="Eliminar tipo de contrato" class="btn btn-danger btn-sm btn-icon delete"> <i class="bi bi-trash"></i></a>
</div>
@endif