@if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos)
    <a href="" data-ps_encargado="{{ $ps_encargado }}" data-imei="{{ $imei }}" data-mac_wifi="{{ $mac_wifi }}" data-serie="{{ $no_serie }}" type="button" title="Vista previa" class="btn btn-primary btn-sm btn-icon view"> <i class="bi bi-eye"></i></a>
    <a href="" data-id="{{ $id }}" data-ps_encargado="{{ $ps_encargado }}" data-imei="{{ $imei }}" data-mac_wifi="{{ $mac_wifi }}" data-serie="{{ $no_serie }}" type="button" title="Editar ps móvil" class="btn btn-success btn-sm btn-icon edit"> <i class="bi bi-pencil"></i></a>
    <a href="" data-id="{{ $id }}" type="button" title="Eliminar ps móvil" class="btn btn-danger btn-sm btn-icon delete"> <i class="bi bi-trash"></i></a>
@endif
