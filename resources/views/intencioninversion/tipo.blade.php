<div class="row">
    <div class="col-md-6 col-12">
        <div class="form-floating mb-3">
            <select name="tipo_id" class="form-control" id="tipoIdInput" required>
                <option value="" disabled selected>Selecciona..</option>
                @foreach($lista_tipos as $tipo)
                <option id="optionInput" value="{{ $tipo->id }}"
                    data-capertura="{{ $tipo->capertura }}"
                    data-cmensual="{{ $tipo->cmensual }}"
                    data-rendimiento="{{ $tipo->rendimiento }}" data-tipo="{{ $tipo->tipo }}">{{
                    $tipo->tipo }}</option>
                @endforeach
            </select>
            <label for="tipoIdInput">Tipo de contrato</label>
        </div>
    </div>
    <div class="col-md-6 col-12">
        <div class="form-floating mb-3">
            <input type="number" step="any" class="form-control"
                placeholder="Ingresa el porcentaje" id="porcentajeInput" name="porcentaje_tipo"
                required>
            <label for="porcentajeInput">Porcentaje (%)</label>
        </div>
    </div>
</div>