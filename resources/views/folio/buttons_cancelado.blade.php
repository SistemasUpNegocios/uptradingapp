@if (auth()->user()->is_root)
    <a href="" data-id="{{ $id }}" type="button" title="Eliminar folio" class="btn btn-danger btn-sm btn-icon delete"> <i class="bi bi-trash"></i></a>
@else
    No tienes accesos
@endif