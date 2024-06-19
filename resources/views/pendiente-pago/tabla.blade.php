<div class="col-12 mb-3">
    <button id="generarVaciado" data-id="{{$id}}" class="btn btn-success"><i class="bi bi-file-earmark-spreadsheet-fill"></i> Generar excel</button>
</div>
@foreach ($contratos as $contrato)
        @php
            $nombre = $contrato->nombre;
            $cont = substr($contrato->contrato, 0, 9);
            $fecha = \Carbon\Carbon::parse($contrato->fecha)->format('d/m/Y');
            $tipo = strtoupper(substr($contrato->tipo, 12));
            $capital = "$".number_format($contrato->inversion_us, 2);

            $pagos = App\Models\PagoCliente::select('pago', 'fecha_pago', 'status')->where('contrato_id', $contrato->id)->groupBy('status')->orderBy('status', 'ASC')->first();
            $rendimiento = "$".number_format($pagos->pago, 2);
            $pendiente = strtoupper(\Carbon\Carbon::parse($pagos->fecha_pago)->formatLocalized('%B'));
        @endphp
        @if($pagos->status != 'Pagado')
            <div class="col-md-6 col-12">
                <table class="table table-dark table-bordered text-center vaciado" style="width: 100%;">
                    <thead>
                        <tr><th colspan="2">{{$nombre}}</th></tr>
                    </thead>
                    <tbody class="table-secondary">
                        <tr>
                            <td>Contrato</td>
                            <td>{{$cont}}</td>
                        </tr>
                        <tr>
                            <td>Fecha de inicio</td>
                            <td>{{$fecha}}</td>
                        </tr>
                        <tr>
                            <td>Tipo</td>
                            <td>{{$tipo}}</td>
                        </tr>
                        
                        @if($tipo === "MENSUAL")
                            <tr>
                                <td>Capital</td>
                                <td>{{$capital}} DLLS</td>
                            </tr>
                            <tr>
                                <td>RENDIMIENTO</td>
                                <td>{{$rendimiento}} DLLS</td>
                            </tr>
                            <tr>
                                <td>PENDIENTE</td>
                                <td>{{$pendiente}} A LA FECHA</td>
                            </tr>
                        @else
                            <tr>
                                <td>Capital & Rendimiento</td>
                                <td>{{$rendimiento}} DLLS</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        @endif
@endforeach