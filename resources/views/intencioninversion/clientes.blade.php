<div class="col-md-6 col-12">
    <div class="form-floating mb-3">
        <select name="nombre" class="form-select selectSearch" id="nombreInput" required style="text-transform: none;">
            <option value="" disabled selected>Selecciona...</option>
            @foreach($clientes as $cliente)
            @php
                $nombre_cliente = $cliente->apellido_p . ' ' .
                $cliente->apellido_m . ' ' . $cliente->nombre;
            @endphp
            <option value="{{ $cliente->id }}" data-id="{{ $cliente->id }}">{{ $nombre_cliente }}</option>
            @endforeach
        </select>
        <label for="nombreInput">Cliente</label>
    </div>
</div>
<div class="col-md-3 col-12">
    <div class="form-floating mb-3">
        <input type="email" class="form-control"
            placeholder="Ingresa el correo electrónico" id="emailInput"
            name="email" required style="text-transform: none;">
        <label for="emailInput">Correo electrónico</label>
    </div>
</div>
<div class="col-md-3 col-12">
    <div class="form-floating mb-3">
        <input type="number" step="any" class="form-control"
            placeholder="Ingresa la cantidad de inversión" id="telefonoInput"
            name="telefono" required>
        <label for="telefonoInput">Número de teléfono</label>
    </div>
</div>