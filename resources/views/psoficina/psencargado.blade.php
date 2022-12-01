@if(!$lista_ps->isEmpty())
<div class="form-floating mb-3">
    <select name="encargado_id" minlength="3" maxlength="120" pattern="[a-zA-Zá-úÁ-Ú ]+"
        class="form-control" id="psEncargadoIdInput" required>
        <option value="" disabled selected>Selecciona..</option>
        @foreach($lista_ps as $ps)
        <option value="{{ $ps->id }}">{{ $ps->nombre }} {{ $ps->apellido_p }} {{ $ps->apellido_m }}</option>
        @endforeach
    </select>
    <label for="psEncargadoIdInput">¿Quién es el encargado del PS?</label>
</div>
@else
<div class="form-floating mb-3">
    <select name="encargado_id" minlength="3" maxlength="120" pattern="[a-zA-Zá-úÁ-Ú ]+"
        class="form-control" id="psEncargadoIdInput" required>
        <option value="" disabled selected>No hay PS registrados en esta oficina</option>
    </select>
    <label for="psEncargadoIdInput">¿Quién es el encargado del PS?</label>
</div>
@endif