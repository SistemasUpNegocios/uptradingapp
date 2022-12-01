@if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos)
    <a href="" data-codigops="{{ $codigoPS }}" data-nombre="{{ $nombre }}" data-oficinaciudad="{{ $oficina_ciudad }}" data-apellidop="{{ $apellido_p }}" data-apellidom="{{ $apellido_m }}" data-fechanac="{{ $fecha_nac }}" data-nacionalidad="{{ $nacionalidad }}" data-direccion="{{ $direccion }}" data-colonia="{{ $colonia }}" data-cp="{{ $cp }}" data-ciudad="{{ $ciudad }}" data-estado="{{ $estado }}" data-celular="{{ $celular }}" data-correop="{{ $correo_personal }}" data-correoi="{{ $correo_institucional }}" data-ine="{{ $ine }}" data-pasaporte="{{ $pasaporte }}" data-vencimientopas="{{ $vencimiento_pasaporte }}" data-oficinaid="{{ $oficina_id }}" data-encargadoid="{{ $encargado_id }}" data-tipops="{{ $tipo_ps }}" data-swift="{{ $swift }}" data-iban="{{ $iban }}" type="button" title="Vista previa" class="btn btn-primary btn-sm btn-icon view"> <i class="bi bi-eye"></i></a>
    <a href="" data-id="{{ $id }}" data-codigops="{{ $codigoPS }}" data-nombre="{{ $nombre }}" data-oficinaciudad="{{ $oficina_ciudad }}" data-apellidop="{{ $apellido_p }}" data-apellidom="{{ $apellido_m }}" data-fechanac="{{ $fecha_nac }}" data-nacionalidad="{{ $nacionalidad }}" data-direccion="{{ $direccion }}" data-colonia="{{ $colonia }}" data-cp="{{ $cp }}" data-ciudad="{{ $ciudad }}" data-estado="{{ $estado }}" data-celular="{{ $celular }}" data-correop="{{ $correo_personal }}" data-correoi="{{ $correo_institucional }}" data-ine="{{ $ine }}" data-pasaporte="{{ $pasaporte }}" data-vencimientopas="{{ $vencimiento_pasaporte }}" data-oficinaid="{{ $oficina_id }}" data-encargadoid="{{ $encargado_id }}" data-tipops="{{ $tipo_ps }}" data-swift="{{ $swift }}" data-iban="{{ $iban }}" type="button" title="Editar PS" class="btn btn-success btn-sm btn-icon edit"> <i class="bi bi-pencil"></i></a>
    <a href="" data-id="{{ $id }}" type="button" title="Eliminar PS" class="btn btn-danger btn-sm btn-icon delete"> <i class="bi bi-trash"></i></a>
@endif

@if (auth()->user()->is_ps_encargado)
    <a href="" data-codigops="{{ $codigoPS }}" data-nombre="{{ $nombre }}" data-oficinaciudad="{{ $oficina_ciudad }}" data-apellidop="{{ $apellido_p }}" data-apellidom="{{ $apellido_m }}" data-fechanac="{{ $fecha_nac }}" data-nacionalidad="{{ $nacionalidad }}" data-direccion="{{ $direccion }}" data-colonia="{{ $colonia }}" data-cp="{{ $cp }}" data-ciudad="{{ $ciudad }}" data-estado="{{ $estado }}" data-celular="{{ $celular }}" data-correop="{{ $correo_personal }}" data-correoi="{{ $correo_institucional }}" data-ine="{{ $ine }}" data-pasaporte="{{ $pasaporte }}" data-vencimientopas="{{ $vencimiento_pasaporte }}" data-oficinaid="{{ $oficina_id }}" data-encargadoid="{{ $encargado_id }}" data-tipops="{{ $tipo_ps }}" data-swift="{{ $swift }}" data-iban="{{ $iban }}" type="button" title="Vista previa" class="btn btn-primary btn-sm btn-icon view"> <i class="bi bi-eye"></i> VER PS</a>
@endif