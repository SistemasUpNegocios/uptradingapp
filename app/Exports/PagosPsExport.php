<?php

namespace App\Exports;

use App\User;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PagosPsExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($fecha, $dolar)
    {
        $this->fecha = $fecha;
        $this->dolar = $dolar;
    }

    public function headings(): array
    {
        return [
            'Nombre del PS',
            // 'Comisión (MXN)',
            'Comisión (USD)',
        ];
    }
    public function collection()
    {
        $fecha = $this->fecha;
        // $lista_ps = DB::table("ps")
        //     ->select(DB::raw("id, CONCAT(nombre, ' ', apellido_p, ' ', apellido_m) AS ps, celular AS comision, codigoPS AS comision_dolares"))
        //     ->orderBy('ps', "ASC")
        //     ->get();

        $lista_ps = DB::table("ps")
            ->select(DB::raw("id, CONCAT(nombre, ' ', apellido_p, ' ', apellido_m) AS ps, codigoPS AS comision_dolares"))
            ->orderBy('ps', "ASC")
            ->get();

        $i = 0;
        foreach ($lista_ps as $ps) {            
            $comision_ps = DB::table('contrato')
                ->join('ps', 'ps.id', '=', 'contrato.ps_id')
                ->join('oficina', 'oficina.id', '=', 'ps.oficina_id')
                ->join('pago_ps', 'pago_ps.contrato_id', '=', 'contrato.id')
                ->where('pago_ps.fecha_limite', 'like', "$fecha%")
                ->where('contrato.ps_id', $ps->id)
                ->where("contrato.status", "Activado")
                ->where('ps.codigoPS', '!=', "IA1")
                ->where('ps.codigoPS', '!=', "IA2")
                ->where('ps.codigoPS', '!=', "IA3")
                ->orderBy('ps.id', 'DESC')
                ->sum('pago_ps.pago');

            if ($comision_ps > 0){
                $ps->ps = $ps->ps;
                // $ps->comision = number_format($comision_ps * $this->dolar, 2);
                $ps->comision_dolares = number_format($comision_ps, 2);
            }else{
                unset($ps->ps);
                unset($ps->comision_dolares);
                // unset($ps->comision);
            }
            unset($ps->id);

            $i++;
        }

        return $lista_ps;
    }
}