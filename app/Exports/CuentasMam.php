<?php

namespace App\Exports;

use App\User;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Convenio;
use App\Models\IncrementoConvenio;
use Carbon\Carbon;

class CuentasMam implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct()
    {

    }

    public function headings(): array
    {
        return [
            'Nombre del cliente',
            'Número de cuenta',
            'Loggin',
            'Monto (USD)',
            'Fecha de inicio',
            'Incremento',
            'Fecha de incremento',
            'Monto incrementado',
            'Periodo',
            'Balance',
            'Equity',
            'Flotante',
        ];
    }
    public function collection()
    {

        $cuentas = Convenio::join("cliente", "cliente.id", "=", "convenio.cliente_id")
        ->select("convenio.id as convenioid", "cliente.nombre", "convenio.numerocuenta", "convenio.loggin", "convenio.monto", "convenio.fecha_inicio", "convenio.cliente_id", "cliente.apellido_p", "cliente.apellido_m", "convenio.fecha_carga")
        ->where("convenio.id", "!=", 39)
        ->groupBy('convenio.cliente_id')
        ->orderBy("convenio.cliente_id", "ASC")
        ->get();

        foreach ($cuentas as $cuenta) {
            $incrementos = IncrementoConvenio::select()
            ->where('convenio_id', $cuenta->convenioid)
            ->first();

            $incrementos_count = IncrementoConvenio::select()
            ->where('convenio_id', $cuenta->convenioid)
            ->count();

            $mes = Carbon::parse($cuenta->fecha_inicio)->format("m");
            $anio = Carbon::parse($cuenta->fecha_inicio)->format("Y");

            $fecha_inicio = Carbon::parse("01-$mes-$anio");
            $fecha_actual = Carbon::now();

            $periodo = $fecha_actual->diffInMonths($fecha_inicio);
            
            if($periodo == 0){
                $periodo = 1;
            }

            if($cuenta->loggin == "" || $cuenta->loggin == NULL){
                $loggin = "NA";
            }else{
                $loggin = $cuenta->loggin;
            }

            if($incrementos_count > 0){
                $incremento = "SI";
            } else {
                $incremento = "NO";
            }

            if ($incrementos_count > 0){
                $fecha_incremento = Carbon::parse($incrementos->fecha_inicio_incremento)->format("d/m/Y");
                $monto_incrementado = number_format($incrementos->cantidad_incremento, 2);
            }else{
                $fecha_incremento = "NA";
                $monto_incrementado = "NA";
            }

            unset($cuenta->convenioid);
            $cuenta->nombre = $cuenta->nombre." ".$cuenta->apellido_p." ".$cuenta->apellido_m;
            $cuenta->loggin = $loggin;
            $cuenta->fecha_inicio = Carbon::parse($cuenta->fecha_inicio)->format("d/m/Y");
            $cuenta->cliente_id = $incremento;
            $cuenta->apellido_p = $fecha_incremento;
            $cuenta->apellido_m = $monto_incrementado;
            $cuenta->fecha_carga = $periodo;
        }

        return $cuentas;
    }
}
