@if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos)
<a href="" data-ciudad="{{ $ciudad }}" data-codigo-oficina="{{ $codigo_oficina }}" data-coord_x="{{ $coord_x }}" data-coord_y="{{ $coord_y }}" type="button" title="Vista previa" class="btn btn-primary btn-sm btn-icon view"> <i class="bi bi-eye"></i></a>
<a href="" data-id="{{ $id }}" data-ciudad="{{ $ciudad }}" data-codigo-oficina="{{ $codigo_oficina }}" data-coord_x="{{ $coord_x }}" data-coord_y="{{ $coord_y }}" type="button" title="Editar oficina" class="btn btn-success btn-sm btn-icon edit"> <i class="bi bi-pencil"></i></a>
<a href="" data-id="{{ $id }}" type="button" title="Eliminar oficina" class="btn btn-danger btn-sm btn-icon delete"> <i class="bi bi-trash"></i></a>
@endif