@if ($tipo_accion == 'Inserción')
    <span class="badge bg-primary"><i class="bi-plus-lg"></i> {{ $tipo_accion }}</span>
@elseif($tipo_accion == 'Actualización')
    <span class="badge bg-success"><i class="bi bi-pencil"></i> {{ $tipo_accion }}</span>
@elseif($tipo_accion == 'Eliminación')    
    <span class="badge bg-danger"><i class="bi bi-trash"></i> {{ $tipo_accion }}</span>
@endif