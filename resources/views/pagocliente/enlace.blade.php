
@if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_ps_gold || auth()->user()->is_egresos || auth()->user()->is_ps_diamond)
<a href="" class="btn btn-sm principal-button new" id="seePagos" data-clienteid="{{ $clienteid }}" data-clientenombre="{{ $clientenombre }}"><i class="bi bi-eye"></i> Ver contratos</a>
@endif