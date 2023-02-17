@if (auth()->user()->is_root)
    <a href="" data-id="{{ $id }}" data-imagen="{{ $evidencia }}" type="button" title="Subir evidencia" class="btn btn-success btn-sm btn-icon edit"> <i class="bi bi-file-image"></i></a>
    <a href="" data-id="{{ $id }}" type="button" title="Eliminar folio" class="btn btn-danger btn-sm btn-icon delete"> <i class="bi bi-trash"></i></a>
@else
    <a href="" data-id="{{ $id }}" data-imagen="{{ $evidencia }}" type="button" title="Subir evidencia" class="btn btn-success btn-sm btn-icon edit"> <i class="bi bi-file-image"></i></a>
@endif

@if ( $evidencia != "default.png" )
    <span class="badge bg-primary">Con Imágen <i class="bi bi-check"></i></span>
@else
    <span class="badge bg-dark">Sin Imágen <i class="bi bi-x"></i></span>
@endif