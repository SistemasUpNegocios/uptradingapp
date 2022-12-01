@if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos)
<a href="" data-id="{{ $id }}" data-redaccion="{{ $redaccion }}" type="button" title="Vista previa" class="btn btn-primary btn-sm btn-icon viewClausula"> <i class="bi bi-eye"></i></a>
<a href="" data-id="{{ $id }}" data-redaccion="{{ $redaccion }}" type="button" title="Editar clausula" class="btn btn-success btn-sm btn-icon editClausula"> <i class="bi bi-pencil"></i></a>
<a href="" data-id="{{ $id }}" type="button" title="Eliminar clausula" class="btn btn-danger btn-sm btn-icon deleteClausula"> <i class="bi bi-trash"></i></a>
@endif