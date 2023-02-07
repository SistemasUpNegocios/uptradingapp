<section class="section">
    <div class="row">
        <div class="col-lg-12">

        <div class="card">
            <div class="card-body mt-3">
                <div class="d-flex justify-content-between align-items-center">
                    <a class="btn principal-button mb-3 new me-1" data-id="{{ $ps->oficina_id }}" id="verPs"> <i class="bi-chevron-left me-1"></i>Volver a ver a los PS</a>
                    <a class="btn principal-button mb-3 new" data-id="{{ $ps->id }}" id="imprimirResumen"> <i class="bi bi-printer-fill me-1"></i>Imprimir resumen</a>
                </div>
                <div class="form-floating mb-3">
                    <input type="month" class="form-control" id="fechaInput" data-id="{{ $ps->id }}" name="fecha">
                    <label for="fechaInput">Fecha de pago</label>
                </div>
                @if(sizeof($resumenes_contrato) > 0 || sizeof($resumenes_convenio) > 0)                    
                    <div class="row">
                        <div class="col-12">
                            <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                <symbol id="info-fill" fill="#fff" viewBox="0 0 16 16">
                                    <path
                                        d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                                </symbol>
                                <symbol id="exclamation-triangle-fill" fill="#fff" viewBox="0 0 16 16">
                                    <path
                                        d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                                </symbol>
                            </svg>
                            <div class="alert alert-primary d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
                                    aria-label="Info:">
                                    <use xlink:href="#info-fill" />
                                </svg>
                                <div>
                                    Resumen del PS {{ $ps->nombre }} {{ $ps->apellido_p }} {{ $ps->apellido_m }} del mes de <span id="mesLetra"></span>.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4" style="overflow-x: auto;">
                        <table class="table table-striped table-bordered nowrap text-center" style="width: 100%" id="resumen">
                            <thead>
                                <tr>
                                    <th data-priority="0" colspan="3"scope="col">{{ $ps->nombre }} {{ $ps->apellido_p }} {{ $ps->apellido_m }}</th>
                                    <th data-priority="0" colspan="2" scope="col">Total: <span style="font-weight: 500">${{ $total }}</span></th>
                                </tr>
                                <tr>
                                    <th data-priority="0" scope="col">Tipo</th>
                                    <th data-priority="0" scope="col">Cliente</th>
                                    <th data-priority="0" scope="col">Comisión</th>
                                    <th data-priority="0" scope="col">Tipo de comisión</th>
                                    <th data-priority="0" scope="col">Pago</th>
                                </tr>
                            </thead>
                            <tbody id="resuemnBody">
                                @foreach ($resumenes_contrato as $resumen)
                                    <tr>
                                        <td>
                                            @if (strlen($resumen->contrato) == 11)
                                                {{ substr($resumen->contrato, 0, -2); }}
                                            @else
                                                {{ substr($resumen->contrato, 0, -3); }}
                                            @endif
                                        </td>
                                        <td>{{ $resumen->clientenombre }}</td>
                                        <td>${{ number_format($resumen->pago, 2) }}</td>
                                        <td>{{ $resumen->memo }}</td>
                                        <td>
                                            @if ($resumen->memo == "Comisión por apertura")
                                            {{ str_pad($resumen->serie, 2, "0", STR_PAD_LEFT) }}/01
                                            @else
                                            {{ str_pad($resumen->serie, 2, "0", STR_PAD_LEFT) }}/12
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                @foreach ($resumenes_convenio as $resumen)
                                    <tr>
                                        <td>
                                            @php
                                                $convenio = explode('-', $resumen->folio);
                                                $convenio = "$convenio[1]-$convenio[2]-$convenio[3]";
                                            @endphp
                                            {{ $convenio }}
                                        </td>
                                        <td>{{ $resumen->clientenombre }}</td>
                                        <td>${{ number_format($resumen->pago, 2) }}</td>
                                        <td>{{ $resumen->memo }}</td>
                                        <td>
                                            @if ($resumen->memo == "Comisión por apertura")
                                            {{ str_pad($resumen->serie, 2, "0", STR_PAD_LEFT) }}/01
                                            @else
                                            {{ str_pad($resumen->serie, 2, "0", STR_PAD_LEFT) }}/12
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="row">
                        <div class="col-12">
                            <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                <symbol id="info-fill" fill="#fff" viewBox="0 0 16 16">
                                    <path
                                        d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                                </symbol>
                                <symbol id="exclamation-triangle-fill" fill="#fff" viewBox="0 0 16 16">
                                    <path
                                        d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                                </symbol>
                            </svg>
                            <div class="alert alert-primary d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
                                    aria-label="Info:">
                                    <use xlink:href="#info-fill" />
                                </svg>
                                <div>
                                    No se encontraron pagos para esta fecha.
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>