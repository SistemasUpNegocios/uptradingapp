<a href="" data-id="{{ $id }}" data-folio="{{ $folio }}" data-firma="{{$firma}}" data-nombrecliente="{{ $clientenombre }}" data-psnombre="{{ $psnombre }}" data-monto="{{ $monto }}" data-monto_letra="{{ $monto_letra }}" data-fecha_inicio="{{ $fecha_inicio }}" data-fecha_fin="{{ $fecha_fin }}" data-capertura="{{ $capertura }}" data-cmensual="{{ $cmensual }}" data-ctrimestral="{{ $ctrimestral }}" data-status="{{ $status }}" data-numerocuenta="{{ $numerocuenta }}" data-loggin="{{$loggin}}" data-ps_id="{{ $ps_id }}" data-cliente_id="{{ $cliente_id }}" data-banco_id="{{ $banco_id }}" type="button" title="Vista previa" class="ms-1 btn btn-primary btn-sm btn-icon view"> <i class="bi bi-eye"></i></a>

<a href="" data-id="{{ $id }}" data-cliente="{{$clientenombre}}" data-notaconvenio="{{$nota_convenio}}" data-folio="{{$folio}}" type="button" title="Nota del convenio" class="ms-1 btn @if ($nota_convenio == null) btn-dark @else btn-secondary @endif btn-sm btn-icon edit mb-1"> <i class="bi bi-journal-text"></i> Nota</a>

@if(auth()->user()->is_root)
    <div class="d-flex align-items-center justify-content-center mt-1">
        <input id="{{$id}}Input" name="autorizacion_nota" class="autorizado form-check-input fs-6 m-0 p-0 ms-1" type="checkbox" data-id="{{$id}}" @if ($autorizacion_nota=="SI" ) {{"checked"}} @endif>
        <label class="form-check-label ms-1" style="font-size: 15px" for="{{$id}}Input">¿Autorizado?</label>
    </div>
@endif