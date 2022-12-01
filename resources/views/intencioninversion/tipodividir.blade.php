<div class="row">
    <div class="col-md-6 col-12">
        <div class="form-floating mb-3">
            <select class="form-control" name="tipo_id" id="tipoIdInput" required>
                <option value="" disabled selected>Selecciona..</option>
                @foreach($lista_tipos as $tipo)
                <option id="optionInput" value="{{ $tipo->id }}" data-capertura="{{ $tipo->capertura }}"
                    data-cmensual="{{ $tipo->cmensual }}" data-rendimiento="{{ $tipo->rendimiento }}"
                    data-tipo="{{ $tipo->tipo }}">{{
                    $tipo->tipo }}</option>
                @endforeach
            </select>
            <label for="tipoIdInput">Tipo de contrato (Primer contrato)</label>
        </div>
    </div>
    <div class="col-md-6 col-12">
        <div class="form-floating mb-3">
            <input type="number" step="any" pattern="[0-9.]+" class="form-control" placeholder="Ingresa el porcentaje"
                id="porcentajeInput" name="porcentaje_tipo" required>
            <label for="porcentajeInput">Porcentaje (%)</label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-12">
        <div class="form-floating mb-3">
            <select class="form-control" name="tipo_id2" id="tipoIdInput2" required>
                <option value="" disabled selected>Selecciona..</option>
                @foreach($lista_tipos as $tipo)
                <option id="optionInput" value="{{ $tipo->id }}" data-capertura="{{ $tipo->capertura }}"
                    data-cmensual="{{ $tipo->cmensual }}" data-rendimiento="{{ $tipo->rendimiento }}"
                    data-tipo="{{ $tipo->tipo }}">{{
                    $tipo->tipo }}</option>
                @endforeach
            </select>
            <label for="tipoIdInput2">Tipo de contrato (Segundo contrato)</label>
        </div>
    </div>
    <div class="col-md-6 col-12">
        <div class="form-floating mb-3">
            <input type="number" step="any" pattern="[0-9.]+" class="form-control" placeholder="Ingresa el porcentaje"
                id="porcentajeInput2" name="porcentaje_tipo2" required>
            <label for="porcentajeInput2">Porcentaje (%)</label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-12">
        <div class="form-floating mb-3">
            <input type="number" step="0.01" name="porcentaje_inversion_1" step="any" pattern="[0-9.]+" class="form-control" placeholder="Ingresa el porcentaje"
                id="porcentajeInversionInput" required>
            <label for="porcentajeInversionInput">Porcentaje de inversión del primer contrato (%)</label>
        </div>
    </div>
    <div class="col-md-6 col-12">
        <div class="form-floating mb-3">
            <input type="number" step="0.01" name="porcentaje_inversion_2" step="any" pattern="[0-9.]+" class="form-control" placeholder="Ingresa el porcentaje"
                id="porcentajeInversionInput2" required>
            <label for="porcentajeInversionInput2">Porcentaje de inversión del segundo contrato (%)</label>
        </div>
    </div>
    <input type="hidden" name="inversionMXN1" id="inversionMXN1">
    <input type="hidden" name="inversionUSD1" id="inversionUSD1">
    <input type="hidden" name="inversionMXN2" id="inversionMXN2">
    <input type="hidden" name="inversionUSD2" id="inversionUSD2">
</div>